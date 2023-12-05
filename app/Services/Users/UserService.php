<?php namespace App\Services\Users;

use App\Models\Ad;
use App\Models\City;
use App\Models\Department;
use App\Models\Region;
use App\Models\Territory;
use App\Models\User;
use App\Notifications\BasicNotification;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services\Users
 */
class UserService
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exists(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * @param array $data
     * @return User
     * @throws \Throwable
     */
    public function create(array $data): User
    {
        if (!isset($data['accept_communication'])) {
            $data['accept_communication'] = 0;
        }
        if (!isset($data['accept_share_contact_infos'])) {
            $data['accept_share_contact_infos'] = 0;
        }

        $data['role'] = 0;

        if (isset($data['city_id'])) {
            $city = City::find($data['city_id']);
            $data['zip_code_id'] = $city->id;
            $data['city'] = $city->name;
        }

        return $this->repository->create($data);

    }

    /**
     * @param array $data
     * @param User $user
     * @return mixed
     */
    public function update(array $data)
    {
        if (isset($data['city_id'])) {
            $city = City::find($data['city_id']);
            $data['zip_code_id'] = $city->id;
            $data['city'] = $city->name;
        }
        if (isset ($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['hasformation']) && $data['hasformation'] === 0) {
            $data['formation'] = null;
        }

        $user = User::where('email', '=', $data['email'])->first();
        if ($user !== null) {
            if ($user->id !== (int)$data['user_id']) {
                return back()->withInput()->withErrors("Cette adresse email est déjà utilisée par un autre utilisateur");
            }
        }
        $user = $this->repository->update($data['user_id'], $data);

        $user = User::find($data['user_id']);
        try {
            $user->notify(new BasicNotification([
                'subject' => "Modifications de vos informations personnelles",
                'message' => "Vos informations personnelles viennent d’être modifiées.\n
                    Pour gérer vos informations personnelles :\n",
                'action' => ["Vos informations personnelles", route('user.edit', ['user' => $user->id]),
                    'salutation' => "A bientôt sur Objectif Terres !"]
            ]));
        } catch (\Exception $e) {
            return back()->with('warning', 'Une erreur est survenue, veuillez réessayer ');
        }

        return $user;
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAllExceptPPAndLoggedUser()
    {
        $users = $this->repository->findAllExceptPPAndLoggedUser();
        $users->map(function ($user, $key) {
            $user['name'] = $user['first_name'] . ' ' . $user['name'];
            return $user;
        });

        return $users;
    }

    /**
     * @return mixed
     */
    public function findAllAdvisorsAndSupervisors()
    {
        return $this->repository->findAllByRole('>=', 2);
    }

    /**
     * @param int $id
     * @return User
     */
    public function findByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * @return array
     */
    public function getCurrentUserTerritoryDepartments(): array
    {
        $supervisorLocationTerritoryCodes = [];

        if (!auth()->id()) {
            return [];
        }

        $userDepartments = User::with('departments')->find(auth()->id());
        foreach ($userDepartments->departments as $department) {
            array_push($supervisorLocationTerritoryCodes, $department->code);
        }
        return $supervisorLocationTerritoryCodes;
    }

    /**
     * @return array
     */
    public function getCurrentUserTerritoryIds()
    {
        $userTerritoryIds = [];
        $userDepartments = User::with('departments', 'departments.territory')->find(auth()->user()->id);
        foreach ($userDepartments->departments as $department) {
            array_push($userTerritoryIds, $department->territory->id);
        }
        return array_unique($userTerritoryIds);
    }


    /**
     * @param int $roleId
     * @param int $regionId
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function findRandomByRoleAndRegion(int $roleId, int $regionId)
    {
        $regionsCodes = Region::whereIn('id', [$regionId])->get('code')->toArray();

        return User::filterSubLocations('departments', $regionsCodes, 'departments.region_code')
            ->where('role', $roleId)
            ->orderBy('name')
            ->first();
    }

    /**
     * @param array $rolesId
     * @param array $departmentCodes
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function findByRolesAndDepartments(array $rolesId, array $departmentCodes)
    {
        return User::filterSubLocations('departments', $departmentCodes, 'departments.code')
            ->whereIn('role', $rolesId)
            ->orderBy('name')
            ->get();
    }

    /**
     * TODO method to delete if not necessary anymore
     * @param int $roleId
     * @param array $regionsId
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function findByRoleAndRegions(int $roleId, array $regionsId)
    {
        $regionsCode = Region::whereIn('id', $regionsId)->get('code')->toArray();
        return User::filterSubLocations('departments', $regionsCode, 'departments.region_code')
            ->where('role', $roleId)
            ->orderBy('name')
            ->get();
    }


    /**
     * @param array $roleIds
     * @param array $territoryIds
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function findByRolesAndTerritory(array $roleIds, array $territoryIds)
    {
        return User::filterSubLocations('departments', $territoryIds, 'departments.territory_id')
            ->whereIn('role', $roleIds)
            ->orderBy('name')
            ->get();
    }

    /**
     * @param int $roleId
     * @param array $territoryIds
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function findAllByRoleAndTerritory(int $roleId, array $territoryIds)
    {
        return User::filterSubLocations('departments', $territoryIds, 'departments.territory_id')
            ->where('role', '>=', $roleId)
            ->with('departments', 'departments.territory', 'userPermissions')
            ->get();
    }


    /**
     * TODO find a prettier way to do the operation
     * @param int $roleId
     * @param $territoryIds
     * @return array
     */
    public function groupAllUsersByTerritory(int $roleId, array $territoryIds)
    {
        $users = $this->findAllByRoleAndTerritory($roleId, $territoryIds);
        $usersGroupedByTerritoryNames = array_fill_keys(Territory::all()->pluck('name')->toArray(), []);
        foreach ($usersGroupedByTerritoryNames as $territoryName => $value) {
            foreach ($users as $user) {
                foreach ($user->departments as $department) {
                    if ($department->territory->name == $territoryName) {
                        if (!in_array($user, $usersGroupedByTerritoryNames[$territoryName])) {
                            array_push($usersGroupedByTerritoryNames[$territoryName], $user);
                        }
                    }
                }
            }
        }
        return $usersGroupedByTerritoryNames;
    }


    /**
     * @param int $permission
     * @param array $departmentCodes
     * @return User|null
     */
    public function findOneByUserPermissionAndDepartments(int $permission, array $departmentCodes): ?User
    {
        $users = $this->repository->findAllByUserPermissionAndDepartments($permission, $departmentCodes);
        if (!empty($users)) {
            return $users->first();
        }
        return null;
    }

}

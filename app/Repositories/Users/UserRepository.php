<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Eloquent\AbstractRepository;

/**
 * Class UserRepository
 *
 * @property User $entity
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function entity()
    {
        return User::class;
    }

    /**
     * Creates a user.
     *
     * @throws \Throwable
     */
    public function create(array $data)
    {
        $user = DB::transaction(function () use ($data) {
            $user = new User;
            $user->fill($data);

            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            return $user;
        });

        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        $model = $this->entity
            ->where(['id' => $id])
            ->first();

        return $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAllExceptPPAndLoggedUser()
    {
        $users = $this->entity
            ->where('role', '>=', 1)
            ->where('id', '<>', auth()->user()->id)
            ->get();

        return $users;
    }

    /**
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return $this->entity->where('email', $email)->withTrashed()->first();
    }

    public function findAllByRole(string $operator, int $roleNumber)
    {
        return $this->entity->where('role', $operator, $roleNumber)->get();
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function findAllByUserPermissionAndDepartments(int $permission, array $departmentCodes)
    {
        return User::filterSubLocations('departments', $departmentCodes, 'departments.code')
            ->whereHas('userPermissions', function (Builder $builder) use ($permission) {
                $builder->where('permission', '=', $permission);
            })
            ->inRandomOrder()
            ->get();
    }
}

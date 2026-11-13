<?php

namespace App\Repositories\Projects;

use App\Models\Ad;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Eloquent\AbstractRepository;

class ProjectsRepository extends AbstractRepository implements ProjectsRepositoryInterface
{
    public function entity()
    {
        return Project::class;
    }

    /**
     * @return mixed
     */
    public function findAllCreatedSinceDate(Carbon $date)
    {
        return $this->entity
            ->where(function (Builder $builder) use ($date) {
                $builder->whereHas('ad', function (Builder $query) use ($date) {
                    $query->whereHas('attributionAd', function (Builder $q) use ($date) {
                        $q->whereDate('created_at', '=', $date);
                        $q->whereNotNull('user_advisor_id');
                    });
                });
            })
            ->get();
    }

    /**
     * @return mixed
     */
    public function findAllBySupportStateAndSinceNumberOfDays(int $supportStateId, int $numberOfDays)
    {
        return $this->entity
            ->where('support_state_id', '=', $supportStateId)
            ->where(function (Builder $builder) use ($numberOfDays) {
                $builder->whereHas('ad', function (Builder $query) use ($numberOfDays) {
                    $query->whereHas('attributionAd', function (Builder $q) use ($numberOfDays) {
                        $q->whereDate('created_at', '=', Carbon::now()->subDays($numberOfDays));
                        $q->whereNotNull('user_advisor_id');
                    });
                });
            })
            ->get();
    }

    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAllByUserIdAndUserRoleAndSupportStageId(int $userId, int $userRole, int $supportStageId)
    {
        return $this->entity
            ->where(['support_stage_id' => $supportStageId])
            ->whereHas('ad', function (Builder $query) use ($userRole, $userId) {
                $query->whereHas('attributionAd', function (Builder $q) use ($userId, $userRole) {
                    if ($userRole === 2) {
                        $q->where('user_advisor_id', '=', $userId);
                    } elseif ($userRole === 3) {
                        $q->where('user_supervisor_id', '=', $userId);
                    }
                });
            })
            ->get();
    }

    /**
     * @return mixed
     */
    public function findAllByUserIdAndUserRoleAndSupportStageIdAndSupportStateId(int $userId, int $userRole, int $supportStageId, int $supportStateId)
    {
        return $this->entity
            ->where(['support_stage_id' => $supportStageId])
            ->where(['support_state_id' => $supportStateId])
            ->whereHas('ad', function (Builder $query) use ($userId, $userRole) {
                $query->whereHas('attributionAd', function (Builder $q) use ($userId, $userRole) {
                    if ($userRole === 2) {
                        $q->where('user_advisor_id', '=', $userId);
                    } elseif ($userRole === 3) {
                        $q->where('user_supervisor_id', '=', $userId);
                    }
                });
            })
            ->get();
    }

    //	/** TODO Check if method to delete */
    //	 * @param array $departmentCodes
    //	 * @param int $userId
    //	 * @param bool $toPaginate
    //	 * @return \Illuminate\Database\Eloquent\Collection
    //	 */
    //	public function findAllInTerritoriesAndUserAdvisor(array $departmentCodes, int $userId, bool $toPaginate)
    //	{
    //		$models = $this->entity
    //			->whereHas('ad', function (Ad $query) use ($departmentCodes) {
    //				$query->filterAdsTerritoryLocations($departmentCodes);
    //			})
    //			->orWhereHas('ad', function (Builder $query) use ($userId) {
    //				$query->whereHas('attributionAd', function (Builder $q) use ($userId) {
    //					$q->where('user_advisor_id', '=', $userId);
    //				});
    //			})
    //			->with([
    //				'ad',
    //				'ad.landSeekAd',
    //				'ad.landOfferAd',
    //				'supportStage',
    //				'supportState',
    //				'projectStatus',
    //			]);
    //		if ($toPaginate) {
    //			$projects = $models->paginate(15);
    //		} else {
    //			$projects = $models->get();
    //		}
    //		return $projects;
    //	}

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllByUserTerritories(int $userId, array $userLocationTerritoryId, array $territoryCodes)
    {
        return $this->entity
            ->whereHas('ad', function (Builder $query) use ($userId, $userLocationTerritoryId, $territoryCodes) {
                $query->whereNotNull('project_id');
                $query->whereHas('userPp', function (Builder $subQuery) {
                    $subQuery->whereNull('deleted_at');
                });
                $query->where(function (Builder $builder) use ($userId) {
                    $builder->whereHas('attributionAd', function (Builder $q) use ($userId) {
                        $q->where('user_supervisor_id', '=', $userId);
                    });
                });
                $query->filterSupportRequestRegionId($userLocationTerritoryId, auth()->user()->role);
                // TODO delete if not necessary anymore
                // previous system when support_request_territory_id did not exist
                $query->orWhere(function (Builder $builder) use ($territoryCodes) {
                    $builder->whereNull('support_request_territory_id');
                    $builder->whereNotNull('project_id');
                    $builder->whereHas('departments', function (Builder $subQuery) use ($territoryCodes) {
                        $subQuery->whereIn('code', $territoryCodes);
                    });
                    $builder->orWhereHas('cities', function (Builder $subQuery) use ($territoryCodes) {
                        $subQuery->whereIn('department_code', $territoryCodes);
                    });
                });
            })
            ->with([
                'ad',
                'ad.landSeekAd',
                'ad.landOfferAd',
                'supportStage',
                'supportState',
                'projectStatus',
            ])
            ->get();
    }
}

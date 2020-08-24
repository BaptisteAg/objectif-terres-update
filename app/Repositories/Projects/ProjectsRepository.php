<?php

namespace App\Repositories\Projects;

use App\Models\Ad;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class ProjectsRepository extends AbstractRepository implements ProjectsRepositoryInterface
{
	public function entity()
	{
		return Project::class;
	}

	/**
	 * @param int $userId
	 * @param int $userRole
	 * @param int $supportStageId
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByUserIdAndUserRoleAndSupportStageId(int $userId, int $userRole, int $supportStageId)
	{
		return $this->entity
			->where(["support_stage_id" => $supportStageId])
			->whereHas('ad', function (Builder $query) use ($userRole, $supportStageId, $userId) {
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
	 * @param int $userId
	 * @param int $userRole
	 * @param int $supportStageId
	 * @param int $supportStateId
	 * @return mixed
	 */
	public function findAllByUserIdAndUserRoleAndSupportStageIdAndSupportStateId(int $userId, int $userRole, int $supportStageId, int $supportStateId)
	{
		return $this->entity
			->where(["support_stage_id" => $supportStageId])
			->where(["support_state_id" => $supportStateId])
			->whereHas('ad', function (Builder $query) use ($userId, $supportStageId, $supportStateId, $userRole) {
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
	 * @param array $departmentCodes
	 * @param int $userId
	 * @param bool $toPaginate
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findAllInTerritoriesAndUserAdvisor(array $departmentCodes, int $userId, bool $toPaginate)
	{
		$models = $this->entity
			->whereHas('ad', function (Ad $query) use ($departmentCodes) {
				$query->filterAdsTerritoryLocations($departmentCodes);
			})
			->orWhereHas('ad', function (Builder $query) use ($userId) {
				$query->whereHas('attributionAd', function (Builder $q) use ($userId) {
					$q->where('user_advisor_id', '=', $userId);
				});
			})
			->with([
				'ad',
				'ad.landSeekAd',
				'ad.landOfferAd',
				'supportStage',
				'supportState',
				'projectStatus',
			]);
		if ($toPaginate) {
			$projects = $models->paginate(15);
		} else {
			$projects = $models->get();
		}
		return $projects;
	}

	/**
	 * @param array $departmentCodes
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByUserTerritories(int $userId, array $territoriesCode)
	{
		return $this->entity
			->whereHas('ad', function (Builder $query) use ($userId, $territoriesCode) {
				$query->whereNotNull('project_id');
				$query->whereHas('userPp', function (Builder $subQuery) {
					$subQuery->whereNull('deleted_at');
				});
				$query->where(function (Builder $builder) use ($userId) {
					$builder->whereHas('attributionAd', function (Builder $q) use ($userId) {
						$q->where('user_supervisor_id', '=', $userId);
					});
				});
				$query->orWhere(function (Builder $builder) use ($territoriesCode) {
					$builder->whereHas('departments', function (Builder $subQuery) use ($territoriesCode) {
						$subQuery->whereIn('code', $territoriesCode);
					});
					$builder->orWhereHas('cities', function (Builder $subQuery) use ($territoriesCode) {
						$subQuery->whereIn('department_code', $territoriesCode);
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
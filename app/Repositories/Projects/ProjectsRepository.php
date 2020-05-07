<?php

namespace App\Repositories\Projects;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
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
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findAllInTerritories(array $departmentCodes)
	{
		return $this->entity
			->whereHas('ad', function (Builder $query) use ($departmentCodes) {
				$query->filterAdsTerritoryLocations($departmentCodes);
			})
			->with([
				'ad',
				'ad.landSeekAd',
				'ad.landOfferAd',
				'projectStatus'
			])
			->get();
	}

	/**
	 * @param array $departmentCodes
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByUserSupervisor(int $userId)
	{
		return $this->entity
			->whereHas('ad', function (Builder $query) use ($userId)  {
				$query->whereHas('attributionAd', function (Builder $q) use ($userId){
					$q->where('user_supervisor_id', '=', $userId);
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
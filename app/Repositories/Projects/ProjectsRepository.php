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
	 * @param int $statusId
	 * @param int $userId
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByUserIdAndUserRoleAndProjectStatusId(int $userId, int $userRole, int $projectStatusId)
	{
		return $this->entity
			->where(["project_status_id" => $projectStatusId])
			->whereHas('ad', function (Builder $query) use ($userRole, $projectStatusId, $userId) {
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


}
<?php

namespace App\Services\Advisors;

use App\Models\Ad;
use App\Models\ProjectStatus;
use App\Models\Thread;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Projects\ProjectsRepository;
use App\Repositories\Threads\ThreadsRepository;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Throwable;


/**
 * Class AdvisorsService
 * @package App\Services\AttributionAds
 */
class AdvisorsService
{
	protected $repository;
	protected $userService;
	protected $adService;
	protected $threadService;
	protected $threadRepository;
	protected $projectRepository;

	/**
	 * AdvisorsService constructor.
	 * @param AdRepository $adRepository
	 * @param UserService $userService
	 * @param AdService $adService
	 * @param ThreadsRepository $threadRepository
	 * @param ThreadService $threadService
	 * @param ProjectsRepository $projectsRepository
	 */
	public function __construct(AdRepository $adRepository, UserService $userService, AdService $adService, ThreadsRepository $threadRepository, ThreadService $threadService, ProjectsRepository $projectsRepository)
	{
		$this->repository = $adRepository;
		$this->userService = $userService;
		$this->adService = $adService;
		$this->threadService = $threadService;
		$this->threadRepository = $threadRepository;
		$this->projectRepository= $projectsRepository;
	}

	/**
	 * Show all ads ads related to advisors
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Collection
	 */
	public function findAllByUserAdvisor(bool $toPaginate)
	{
		$advisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
		$ads = $this->repository->allInTerritories($advisorLocationTerritoryCodes, $toPaginate);
		return $ads;
	}

	/**
	 * @param Request $filters
	 * @return LengthAwarePaginator
	 */
	public function showForAdvisor(Request $filters): LengthAwarePaginator
	{
		$ads = $this->adService->filter($filters, auth()->user()->role);
		return $ads;
	}

	/**
	 * @param array $data
	 */
	public function updateSupport(array $data)
	{
		$ad = Ad::find($data['ad_id']);
		if(isset($data['support_stage'])){
			$ad->project->support_stage_id = $data['support_stage'];

		}elseif(isset($data['support_state'])){
			$ad->project->support_state_id = $data['support_state'];

		}elseif(isset($data['project_status'])){
			$ad->project->project_status_id = $data['project_status'];
		}
		$ad->project->save();
	}

	/**
	 * @param int $adId
	 * @return Thread| null
	 */
	public function findSupportRequestThread(int $adId)
	{
		/** @var Thread $thread */
		$thread = $this->threadRepository->findThreadByUserIdAndAdId(auth()->id(),$adId)->first();
		return $thread;
	}

	/**
	 * @param int $supportStageId
	 * @param int $supportStateId
	 * @return mixed
	 */
	public function findAllBySupportStageAndSupportState(int $supportStageId, int $supportStateId)
	{
		$projects = $this->projectRepository->findAllByUserIdAndUserRoleAndSupportStageIdAndSupportStateId(auth()->user()->id, auth()->user()->role, $supportStageId, $supportStateId);
		return $projects;
	}

	/**
	 * @param int $adId
	 * @return Thread|null
	 * @throws Throwable
	 */
	public function createSupportRequestThread(int $adId)
	{
		$threadData = [
			'ad_id'=> $adId,
			'advisor_id'=> auth()->user()->id
		];
		$this->threadService->create($threadData);
		$thread = $this->findSupportRequestThread($adId);
		return $thread;
	}


}
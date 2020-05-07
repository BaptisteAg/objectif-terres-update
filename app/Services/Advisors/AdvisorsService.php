<?php

namespace App\Services\Advisors;

use App\Models\Ad;
use App\Models\ProjectStatus;
use App\Models\Thread;
use App\Repositories\Ads\AdRepository;
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

	/**
	 * AdvisorsService constructor.
	 * @param AdRepository $adRepository
	 * @param UserService $userService
	 * @param AdService $adService
	 * @param ThreadsRepository $threadRepository
	 * @param ThreadService $threadService
	 */
	public function __construct(AdRepository $adRepository, UserService $userService, AdService $adService, ThreadsRepository $threadRepository, ThreadService $threadService)
	{
		$this->repository = $adRepository;
		$this->userService = $userService;
		$this->adService = $adService;
		$this->threadService = $threadService;
		$this->threadRepository = $threadRepository;
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
	 * @return Collection
	 */
	public function findAllAvailableSupportRequestStatusForAdvisors() : Collection
	{
		$unavailableSupportRequestStatusesForAdvisors = [
			ProjectStatus::ASSISTING_ID,
			ProjectStatus::UNASSISTED_ID
		];
		$supportRequestStatuses = ProjectStatus::whereNotIn('id', $unavailableSupportRequestStatusesForAdvisors)->get();
		return $supportRequestStatuses;
	}

	/**
	 * @param array $data
	 */
	public function updateSupportRequestStatus(array $data)
	{
		$ad = Ad::find($data['ad_id']);
		$ad->project->project_status_id = $data['support_request_status'];
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
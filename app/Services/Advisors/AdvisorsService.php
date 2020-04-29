<?php

namespace App\Services\Advisors;
use App\Repositories\Ads\AdRepository;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


/**
 * Class AdvisorsService
 * @package App\Services\AttributionAds
 */
class AdvisorsService
{
	protected $repository;
	protected $userService;

	/**
	 * AdvisorsService constructor.
	 * @param AdRepository $adRepository
	 * @param UserService $userService
	 */
	public function __construct(AdRepository $adRepository, UserService $userService)
	{
		$this->repository = $adRepository;
		$this->userService = $userService;
	}

	/**
	 * Show all ads ads related to advisors
	 * @return LengthAwarePaginator
	 */
	public function findAllByUserAdvisor(): LengthAwarePaginator
	{
		$advisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
		$ads = $this->repository->findAllByUserTerritoriesAndDates($advisorLocationTerritoryCodes);
		return $ads;
	}


}
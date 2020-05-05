<?php

namespace App\Services\Advisors;

use App\Repositories\Ads\AdRepository;
use App\Services\Ads\AdService;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


/**
 * Class AdvisorsService
 * @package App\Services\AttributionAds
 */
class AdvisorsService
{
	protected $repository;
	protected $userService;
	protected $adService;

	/**
	 * AdvisorsService constructor.
	 * @param AdRepository $adRepository
	 * @param UserService $userService
	 * @param AdService $adService
	 */
	public function __construct(AdRepository $adRepository, UserService $userService, AdService $adService)
	{
		$this->repository = $adRepository;
		$this->userService = $userService;
		$this->adService = $adService;
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


}
<?php

namespace App\Services\Advisors;

use App\Models\Ad;
use App\Models\AdNote;
use App\Models\ProjectDataKey;
use App\Models\Thread;
use App\Repositories\AdNotes\AdNotesRepository;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Projects\ProjectsRepository;
use App\Repositories\Threads\ThreadsRepository;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
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
	protected $adNotesRepository;

	/**
	 * AdvisorsService constructor.
	 * @param AdRepository $adRepository
	 * @param UserService $userService
	 * @param AdService $adService
	 * @param ThreadsRepository $threadRepository
	 * @param ThreadService $threadService
	 * @param ProjectsRepository $projectsRepository
	 * @param AdNotesRepository $adNotesRepository
	 */
	public function __construct(AdRepository $adRepository, UserService $userService, AdService $adService, ThreadsRepository $threadRepository, ThreadService $threadService, ProjectsRepository $projectsRepository, AdNotesRepository $adNotesRepository)
	{
		$this->repository = $adRepository;
		$this->userService = $userService;
		$this->adService = $adService;
		$this->threadService = $threadService;
		$this->threadRepository = $threadRepository;
		$this->projectRepository = $projectsRepository;
		$this->adNotesRepository = $adNotesRepository;
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
	 * Show all ads that are supports related to advisors
	 * @param bool $toPaginate
	 * @return LengthAwarePaginator|Collection
	 */
	public function findAllSupportsByUserAdvisor(bool $toPaginate)
	{
		$advisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
		$ads = $this->repository->allProjectsInTerritories($advisorLocationTerritoryCodes, $toPaginate);
		return $ads;
	}

	/**
	 * @param Request $request
	 * @return LengthAwarePaginator|Builder[]|Collection
	 */
	public function showForAdvisor(Request $request)
	{
		$toPaginate = $request->has('toPaginate') ? true : false;
		$ads = $this->adService->filter($request, auth()->user()->role, $toPaginate);
		return $ads;
	}

	/**
	 * @param array $data
	 */
	public function updateSupport(array $data)
	{
		$ad = Ad::find($data['ad_id']);
		if (isset($data['support_stage'])) {
			$ad->project->support_stage_id = $data['support_stage'];

		} elseif (isset($data['support_state'])) {
			$ad->project->support_state_id = $data['support_state'];

		} elseif (isset($data['project_status'])) {
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
		$thread = $this->threadRepository->findThreadByUserIdAndAdId(auth()->id(), $adId)->first();
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
			'ad_id' => $adId,
			'advisor_id' => auth()->user()->id
		];
		$this->threadService->create($threadData);
		$thread = $this->findSupportRequestThread($adId);
		return $thread;
	}

	/**
	 * @param Request $request
	 */
	public function createNote(Request $request)
	{
		try {
			$this->adNotesRepository->create($request->all());
		} catch (Throwable $e) {
			dd($e);
		}

	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function editNote(array $data)
	{
		try {
			$note = AdNote::findOrNew($data['ad_note_id']);
			if ($note->value !== $data['value']) {
				$note->update($data);
				session(['success' => 'La note a bien été modifiée']);
			} else {
				session(['warning' => 'Le contenu de la note n\'a pas été modifié']);
			}
		} catch (\Exception $e) {
			session(['warning' => 'Une erreur s\'est produite, veuillez réessayer']);
		}

	}

	/**
	 * @param Request $request
	 * @throws \Exception
	 */
	public function deleteNote(Request $request)
	{
		$note = AdNote::find($request->input('ad_note_id'));
		$note->delete();
	}


	/**
	 * @param Request $request
	 * @throws Throwable
	 */
	public function updateProjectDataKeysValues(Request $request)
	{
		$requestProjectDataKeyValues = array_filter($request->input('project_data_key'));

		$previousValues = $this->adNotesRepository->findAllNotesWithPublicProjectDatKeysByAdId($request->input('ad_id'));

		$previousValues->filter(function ($note) use ($request, &$requestProjectDataKeyValues) {
			if (array_key_exists($note->project_data_key_id, $requestProjectDataKeyValues)) {
				if ($note->value != $requestProjectDataKeyValues[$note->project_data_key_id]) {
					$note->value = $requestProjectDataKeyValues[$note->project_data_key_id];
					$note->user_id = $request->input('user_id');
					$note->save();

					$projectDataKey = ProjectDataKey::whereId($note->project_data_key_id)->with('projectDataValues')->first();

					if ($projectDataKey->projectDataValues->count() > 0) {
						$projectDataKey->projectDataValues->filter(function ($projectDataValue) use ($note, $requestProjectDataKeyValues) {
							if ($projectDataValue->value === $requestProjectDataKeyValues[$note->project_data_key_id]) {
								$note->projectDataValue()->associate($projectDataValue->id);
								$note->save();
							}
						});
					}
				}
				unset($requestProjectDataKeyValues[$note->project_data_key_id]);
			}
		});
		if (count($requestProjectDataKeyValues) > 0) {
			foreach ($requestProjectDataKeyValues as $key => $value) {
				$data = Arr::only($request->input(), [
					"ad_id",
					"user_id"
				]);
				$data['value'] = $value;
				$data['project_data_key_id'] = $key;
				$this->adNotesRepository->create($data);
			}
		}
	}

	/**
	 * @param array $data
	 * @return Builder[]|Collection
	 */
	public function findNotesByProjectDataKey(array $data)
	{
		$notes = $this->adNotesRepository->findAllByProjectDataKeyAndAdId($data);
		return $notes;
	}

	/**
	 * @param int $adId
	 * @return Builder[]|Collection
	 */
	public function allNotesWithPublicProjectDatKeysByAdId(int $adId): Collection
	{
		$notes = $this->adNotesRepository->findAllNotesWithPublicProjectDatKeysByAdId($adId);
		return $notes;
	}

	/**
	 * @param array $data
	 */
	public function uploadDocument(array $data)
	{
		$ad = $this->repository->find($data['ad_id']);
		if (isset($data["documents_ids"]) && is_array($data["documents_ids"])) {
			foreach ($data["documents_ids"] as $documentId) {
				$ad->documents()->attach($documentId);
			}
		}
	}


	public function handleSupportDashboardNotifications(Ad $ad)
	{
		if (!auth()->user()->unreadNotifications->isEmpty()) {
		    /** @var Notification[] $notifications */
			$notifications = auth()->user()->unreadNotifications;
			foreach ($notifications as $notification) {
				if (array_key_exists('ad_id', $notification->data) && $notification->data['ad_id'] === $ad->id) {
					$notification->markAsRead();
					$notification->delete();
				}
			}
		}
	}


}
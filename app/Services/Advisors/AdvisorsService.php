<?php

namespace App\Services\Advisors;

use App\Models\Ad;
use App\Models\AdNote;
use App\Models\ProjectDataKey;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\BasicNotification;
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
		$advisorLocationTerritoryId = $this->userService->getCurrentUserTerritoryIds();
		$ads = $this->repository->allInTerritories($advisorLocationTerritoryCodes, $advisorLocationTerritoryId, $toPaginate);

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
		$advisorLocationTerritoryId = $this->userService->getCurrentUserTerritoryIds();
		$ads = $this->repository->allProjectsInTerritories($advisorLocationTerritoryCodes, $advisorLocationTerritoryId, $toPaginate);
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
	 * @param array $data
	 * @return Thread
	 */
	public function findThreadAdvisorInChargeOfSupportRequest(array $data)
	{
		$thread = $this->threadRepository->findThreadByUserIdAndAdId($data['user_id'], $data['ad_id'])->first();
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
	public function allNotesWithProjectDatKeysByAdId(int $adId): Collection
	{
		$notes = $this->adNotesRepository->findAllNotesWithProjectDataKeysByAdId($adId);
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

	/**
	 * @param int $UserId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function blockUser(int $UserId)
	{
		$userPp = User::find($UserId);
		try {
			$userPp->delete();
			$userPp->notify(new BasicNotification([
				'subject' => "Votre compte est suspendu temporairement",
				'message' => "Votre compte Objectif Terres vient d’être suspendu puisque vous avez dépassé le cadre d’utilisation d’Objectif Terres.\n
                    Pour rappel, notre charte d’utilisation est disponible ici :\n",
				'action' => ["Charte d'utilisation Objectif Terres", asset('docs/OT_charte_oct2020.pdf'),
					'salutation' => "Merci de votre compréhension,"]
			]));
		} catch (\Exception $e) {
			return back()->with('warning', 'Une erreur est survenue, veuillez réessayer ');
		}

	}


}
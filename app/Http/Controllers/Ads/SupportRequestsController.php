<?php

namespace App\Http\Controllers\Ads;


use App\Exceptions\AttributionAdException;
use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\CmsPage;
use App\Models\ProjectDataKey;
use App\Models\Territory;
use App\Models\User;
use App\Notifications\BasicNotification;
use App\Notifications\NewSupportRequestNotification;
use App\Notifications\SupportRequestAttributionNotification;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class SupportRequestsController extends BaseController
{
	public const SUPPORT_REQUESTS_LIMIT_PER_USER = 1;

	/**
	 * Display the ad edit form
	 * @return \Illuminate\View\View
	 * @throws \Exception
	 */
	public function edit()
	{
		/** @var User $user */
		$user = auth()->user();

		$ad = $this->adService->find($user->supportRequest->id);

		$vars = $this->getEditFormVars($ad);
		return view('pages.ads.new', $vars);
	}

	/**
	 * Display the ad creation form
	 * @return \Illuminate\View\View
	 */
	public function start()
	{
		/** @var User $user */
		$user = auth()->user();

		if ($user && $user->supportRequests()->count() >= self::SUPPORT_REQUESTS_LIMIT_PER_USER) {
			return back()->withErrors(
				"Vous avez déjà rempli une demande d’accompagnement. Pour mettre à jour votre projet ou nous contacter, allez dans votre compte"
			);
		}

		$vars = array_merge($this->getCreateFormVars(), [
			'isSupportRequest' => 1,
			'territories' => Territory::all(),
			'pageContent' => CmsPage::where('slug', 'like', "%etre-accompagne%")->get()->keyBy('slug')
		]);
		return view('pages.ads.support-request', $vars);
	}

	/**
	 * Display the ad creation form
	 */
	public function processStart()
	{
		session()->put([
			'support-request.text' => request('support_request_text'),
			'support-request.territory_id' => request('support_request_territory_id')
		]);

		return redirect()->route('support-request.create');
	}

	/**
	 * Display the ad creation form
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		$vars = array_merge($this->getCreateFormVars(), [
			'isSupportRequest' => 1
		]);

		$vars["ads"] = auth()->user()->ads->filter(function (Ad $ad) {
			return in_array($this->adService->getAdType($ad), ["land_seek", "land_offer"]);
		});

		return view('pages.ads.new', $vars);
	}

	/**
	 *
	 * @return \Illuminate\View\View
	 * @throws \Exception
	 */
	public function createFromAd(Ad $ad)
	{
		$vars = $this->getEditFormVars($ad);

		if (empty($vars["old"]["support_request_text"])) {
			$vars["old"]["support_request_text"] = session('support-request.text');
		}

		unset($vars["old"]["id"]);

		return view('pages.ads.new', $vars);
	}

	/**
	 * @param AdRequest $request
	 * @param int $isDraft
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws Throwable
	 */
	public function submitRequest(AdRequest $request, $isDraft = 0)
	{
		$data = $request->validated();
		$data = array_merge($data, ['is_draft' => $isDraft]);
		/** @var $ad Ad $ad */
		try {

			if ($isDraft === 1) {
				if (!empty($data["id"])) {
					$ad = $this->adService->update($data["id"], $data);
					$success = "Votre demande d'accompagnement a bien été mise à jour et sauvegardée";
				} else {
					$ad = $this->adService->requestPublishing($data, true);
					$success = "Votre demande d'accompagnement a créée et sauvegardée";
				}
			} elseif (!empty($data["id"])) {
				// If this is an update, we'll skip the publishing/attribution part only if the territory doesn't change
				$ad = $this->adService->update($data["id"], $data);
				if ($ad->wasChanged('support_request_territory_id') || $ad->wasChanged('is_draft')) {
					$this->attributionAdService->changeSupportRequestTerritory($ad);
					$this->adService->handleSupportRequestAttributionNotifications($ad);
				}
				$success = "Votre demande a bien été mise à jour.";
			} else {
				$ad = $this->adService->requestPublishing($data, true);
				$success = 'Votre demande a bien été soumise. Vous receverez une réponse très bientôt !';

				if (isset($data['support_request_text'])) {
					$data = [
						'ad_id' => $ad->id,
						'content' => $data['support_request_text'],
						'title' => $ad->title,
					];
					if ($ad->attributionAd->userAdvisor) {
						$data['advisor_id'] = $ad->attributionAd->userAdvisor->id;
					}
					$this->threadService->createSupportRequestThreadFromResume($data);
				}
				$this->adService->handleSupportRequestAttributionNotifications($ad);
			}
			session()->forget('support-request');
		} catch (AttributionAdException $exception) {
			Bugsnag::notifyException($exception);
			return back()->withInput()->withErrors("(Erreur 54) Désolé, l'opération n'a pas pu être effectuée. Nous en avons été informé et nous faisons le maximum pour résoudre le probleme rapidement. Veuillez réessayer un peu plus tard.");
//			return back()->withInput()->withErrors($exception->getMessage());
		} /** Probably an unexpected error */
		catch
		(\Exception $exception) {
			Bugsnag::notifyException($exception);
			logger()->error($exception->getMessage(), $exception->getTrace());
			return back()->withInput()->withErrors(
				"Une erreur imprévu a eu lieu . Merci de nous contacter en précisant le message d'erreur suivant : '
				[" . date('d/m/Y H:i:s') . "]' " . $exception->getMessage()
			);
		}

		return redirect()->route('support-request.show')
			->with('success', $success);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Exception
	 */
	public function show()
	{
		/** @var User $currentUser */
		$currentUser = auth()->user();
		$ad = $this->adService->getUserSupportRequest($currentUser);

		if (is_null($ad)) {
			abort(404);
		}

		$vars = $this->getShowVars($ad);

		$vars["isSupportRequest"] = true;

		$vars["allProjectDataKeys"] = ProjectDataKey::with('projectDataValues')->where("is_public", 1)->get();
		$vars["currentProjectKeyDataValues"] = $this->adService->allPublicNotesWithProjectDatKeysByAdId($ad->id);

		return view('pages.ads.show', $vars);
	}

	/**
	 * @param \Illuminate\Support\Facades\Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function save(AdRequest $request)
	{

		return $this->submitRequest($request, 1);
	}


	/**
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws Throwable
	 */
	public function updateProjectDataKeysValues(Request $request)
	{
		if (!$request->has('project_data_key')) {
			return back()->with('warning', 'Une erreur est survenue, veuillez réessayer');

		}
		$this->adService->updateProjectDataKeysValues($request);
		return back()->with('success', 'Les indicateurs ont bien été modifié');
	}

	protected function getEditFormVars(Ad $ad): array
	{
		$vars = array_merge(parent::getEditFormVars($ad), [
			'isSupportRequest' => 1
		]);

		if (!is_null($ad->support_request_territory_id)) {
			$vars = array_merge($vars, [
				'support_request_territory_id' => $ad->support_request_territory_id,
				'territories' => Territory::all()->whereIn('id', Territory::$territoriesIdAllowToUseService),
				'pageContent' => CmsPage::where('slug', 'like', "%etre-accompagne%")->get()->keyBy('slug')
			]);
			$vars["old"]["support_request_territory_id"] = $ad->support_request_territory_id;

		}

		if ($ad->landOfferAd) {
			if ($ad->landOfferAd->building) {
				$vars["old"]["land_offer"]["building"]["offer_genres"] = $ad->landOfferAd->building->offerGenres->pluck("id")->toArray();
			}
			if ($ad->landOfferAd->house) {
				$vars["old"]["land_offer"]["house"]["offer_genres"] = $ad->landOfferAd->house->offerGenres->pluck("id")->toArray();
			}
		}

		if ($ad->landSeekAd) {
			$vars["old"]["land_seek"]["offer_genres"] = $ad->landSeekAd->offerGenres->pluck("id")->toArray();
			$vars["old"]["land_seek"]["education_levels"] = $ad->landSeekAd->educationLevels->pluck("id")->toArray();
		}

		return $vars;
	}
}


<?php

namespace App\Http\Controllers\ResponseTemplates;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResponseTemplateRequest;
use App\Models\ResponseTemplate;
use App\Repositories\ResponseTemplates\ResponseTemplatesRepository;
use App\Services\Threads\ThreadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResponseTemplatesController extends Controller
{
	protected $repository;
	protected $threadService;

	/**
	 * ResponseTemplatesController constructor.
	 * @param ResponseTemplatesRepository $responseTemplatesRepository
	 * @param ThreadService $threadService
	 */
	public function __construct(ResponseTemplatesRepository $responseTemplatesRepository, ThreadService $threadService)
	{
		$this->repository = $responseTemplatesRepository;
		$this->threadService = $threadService;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$responseTemplates = ResponseTemplate::orderBy('title')->get();
		return view('pages.responseTemplates.index', compact('responseTemplates'));
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function create(ResponseTemplateRequest $request)
	{
		$data = $request->validated();
		$data['content'] = $this->threadService->convertContentToHTML($data['content']);
		$newResponseTemplate = $this->repository->create($request->validated());
		if (empty($newResponseTemplate->getAttributes())) {
			return back()->with('warning', 'Une erreur s\'est produite, veuillez réessayer');
		} else {
			return back()->with('success', 'La réponse a bien été créée');
		}
	}

	/**
	 * @param ResponseTemplate $request
	 */
	public function edit(ResponseTemplateRequest $request)
	{
		if (!$request->has('response_template_id')) {
			return back()->with('warning', 'Une erreur s\'est produite, veuillez réessayer');
		}
		$this->repository->edit($request->input('response_template_id'), $request->validated());
		return back()->with('success', 'La réponse a bien été modifiée');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function delete(Request $request)
	{
		$responseTemplate = ResponseTemplate::find($request->input('response_template_id'));
		if (!isset($responseTemplate)) {
			return back()->with('warning', 'Une erreur s\'est produite, veuillez réessayer');
		}
		$responseTemplate->delete();
		return back()->with('success', 'La réponse a bien été supprimée');
	}


}
<?php

namespace App\Http\Controllers\AdMessages;

use App\Http\Controllers\Controller;
use App\Services\AdMessages\AdMessagesService;
use Illuminate\Http\Request;


class AdMessagesController extends Controller
{
	/**
	 * @var AdMessagesService
	 */
	protected $adMessageService;

	public function __construct(AdMessagesService $adMessageService)
	{
		$this->adMessageService = $adMessageService;
	}

	public function create(Request $request)
	{

		$adMessage = $this->adMessageService->create($request);

		return back()->with('success', 'Votre message a bien été envoyé au porteur de projet !');
	}
}

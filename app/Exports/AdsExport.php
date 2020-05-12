<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdsExport implements FromView,  WithTitle
{
	protected $ads;

	/**
	 * AdsExport constructor.
	 * @param object $ads
	 */
	public function __construct(object $ads){
		$this->ads = $ads;
	}

	/**
	 * @return View
	 */
	public function view(): View
	{
		return view('export.ads_list', [
			'ads' => $this->ads
		]);
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Liste des annonces';
	}
}

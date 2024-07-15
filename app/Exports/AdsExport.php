<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdsExport implements FromView,  WithTitle, WithColumnWidths
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

	public function columnWidths(): array
	{
		return [
			'B' => 10,
			'D' => 35,
			'F' => 20,
			'G' => 25,
			'N' => 50,
			'O' => 50,
			'Q' => 30,
			'AA' => 30,
			'AN' => 30,
		];
	}


	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Liste des annonces';
	}
}

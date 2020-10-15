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
	 * @param array $ads
	 */
	public function __construct(array $ads){
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
			'A' => 10,
			'B' => 35,
			'D' => 20,
			'E' => 25,
			'H' => 50,
			'I' => 50,
			'K' => 30,
			'U' => 30,
			'AH' => 30,
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

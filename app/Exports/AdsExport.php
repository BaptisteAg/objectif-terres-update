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
			'A' => 10,
			'C' => 35,
			'E' => 20,
			'F' => 25,
			'M' => 50,
			'N' => 50,
			'P' => 30,
			'Z' => 30,
			'AM' => 30,
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

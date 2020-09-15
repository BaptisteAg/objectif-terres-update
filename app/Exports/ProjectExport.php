<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;


class ProjectExport implements FromView, WithTitle, WithColumnWidths
{
	protected $ads;

	/**
	 * ProjectExport constructor.
	 * @param object $ads
	 */
	public function __construct(object $ads)
	{
		$this->ads = $ads;
	}

	/**
	 * @return View
	 */
	public function view(): View
	{
		return view('export.projects_list', [
			'ads' => $this->ads
		]);
	}


	public function columnWidths(): array
	{
		return [
			'A' => 20,
			'B' => 25,
			'E' => 50,
			'G' => 30,
			'O' => 30,
			'W' => 30,
			'AC' => 30,
			'AD' => 30
		];
	}


	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Liste demandes accompagnement';
	}

}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ProjectExport implements FromView,  WithTitle
{
	protected $ads;

	/**
	 * ProjectExport constructor.
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
		return view('export.projects_list', [
			'ads' => $this->ads
		]);
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Liste demandes accompagnement';
	}

}

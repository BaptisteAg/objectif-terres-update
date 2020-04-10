<?php

namespace App\Exports\Supervisors;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class PpExport implements FromView,  WithTitle, ShouldAutoSize
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
		return view('export.supervisors.pp_list', [
			'ads' => $this->ads
		]);
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Liste des porteurs de projet';
	}

}

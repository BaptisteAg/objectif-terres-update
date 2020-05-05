<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class PpExport implements FromView,  WithTitle, ShouldAutoSize
{
	protected $ads;

	/**
	 * ProjectExport constructor.
	 * @param  $ads
	 */
	public function __construct(Collection $ads){
		$this->ads = $ads->unique('user_pp_id');
	}

	/**
	 * @return View
	 */
	public function view(): View
	{
		return view('export.pp_list', [
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

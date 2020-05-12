<?php

namespace App\Exports\Advisors;


use App\Exports\AdsExport;
use App\Exports\PpExport;
use App\Exports\ProjectExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AdvisorsExport implements WithMultipleSheets
{
	use Exportable;

	protected $ads;

	public function __construct(object $ads)
	{
		$this->ads = $ads;
	}

	/**
	 * @return array
	 */
	public function sheets(): array
	{
		$sheets = [];
		$sheets[] = new ProjectExport($this->ads);
		$sheets[] = new PpExport($this->ads);
		$sheets[] = new AdsExport($this->ads);

		return $sheets;
	}
}

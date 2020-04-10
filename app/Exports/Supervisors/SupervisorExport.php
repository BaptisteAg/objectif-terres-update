<?php

namespace App\Exports\Supervisors;

use App\Exports\Supervisors\AdsExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SupervisorExport implements WithMultipleSheets
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

<?php namespace App\Exports\Spip;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdsExport implements FromCollection
{
    /**
     * @var array
     */
    protected $ads;

    public function __construct(array $ads)
    {
        $this->ads = $ads;
    }

    public function collection()
    {
        return new Collection($this->ads);
    }
}
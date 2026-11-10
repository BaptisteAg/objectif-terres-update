<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdsExport implements FromView, WithColumnWidths, WithTitle
{
    protected $ads;

    /**
     * AdsExport constructor.
     */
    public function __construct(object $ads)
    {
        $this->ads = $ads;
    }

    public function view(): View
    {
        return view('export.ads_list', [
            'ads' => $this->ads,
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

    public function title(): string
    {
        return 'Liste des annonces';
    }
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class PpExport implements FromView, ShouldAutoSize, WithTitle
{
    protected $ads;

    /**
     * ProjectExport constructor.
     */
    public function __construct(object $ads)
    {
        $this->ads = $ads->unique('user_pp_id');
    }

    public function view(): View
    {
        return view('export.pp_list', [
            'ads' => $this->ads,
        ]);
    }

    public function title(): string
    {
        return 'Liste des porteurs de projet';
    }
}

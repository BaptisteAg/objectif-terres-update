<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProjectExport implements FromView, WithColumnWidths, WithTitle
{
    use Exportable;

    protected $ads;

    /**
     * ProjectExport constructor.
     */
    public function __construct(object $ads)
    {
        $this->ads = $ads;
    }

    public function view(): View
    {
        return view('export.projects_list', [
            'ads' => $this->ads,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'E' => 50,
            'G' => 30,
            'T' => 30,
            'AB' => 30,
            'AH' => 30,
            'AI' => 30,
        ];
    }

    public function title(): string
    {
        return 'Liste demandes accompagnement';
    }
}

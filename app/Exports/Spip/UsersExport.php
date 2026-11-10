<?php

namespace App\Exports\Spip;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @var array
     */
    protected $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return new Collection($this->users);
    }
}

<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('id', 'name', 'email', 'type', 'birthdate', 'status')->get();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Type',
            'Birthdate',
            'Status',
        ];
    }
}

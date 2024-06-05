<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    
    public function headings(): array
    {
        return ["First Name","Last Name","Email","Contact","Date of Birth"];
    }
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('first_name','last_name','email','contact','date_of_birth')->get();
    }
}
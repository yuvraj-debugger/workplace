<?php

namespace App\Imports;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            User::create([
                'first_name' => $row[0],
                'last_name'=> $row[1], 
                'email'=> $row[2], 
                'date_of_birth'=> $row[3],
                'joining_date'=> $row[4], 
                'contact'=> $row[5],
            ]);
        }
    }
}

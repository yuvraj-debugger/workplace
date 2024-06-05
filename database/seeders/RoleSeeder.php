<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = [
            [
                'name' => 'Management'
            ],
            [
                'name' => 'Staff'
            ],
            [
                'name' => 'Client'
            ],
            [
                'name' => 'HR'
            ],
            [
                'name' => 'Employee'
            ]
        ];
        Role::insert($role);
        
    }
}

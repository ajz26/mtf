<?php

namespace Modules\Employee\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EmployeeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        \Modules\Employee\Entities\Employee::factory(10)->create();

        \Modules\Employee\Entities\Employee::factory()->create([
            'name' => 'Test Employee',
            'email' => 'test@example.com',
        ]);
    }
}

<?php

namespace Bahraminekoo\Employee\Database\Seeds;

use Illuminate\Database\Seeder;
use Bahraminekoo\Employee\Models\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class, 10)->create()->each(function ($manager) {
            if(rand(1, 2) == 2) {
                $manager->employees()->saveMany(factory(Employee::class, rand(1, 7))->make());
            }
        });;
    }
}

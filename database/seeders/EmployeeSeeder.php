<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::factory()
            ->count(10)
            ->hasAttached(
               Company::all()->random(rand(1,3)),
                new Sequence(fn ($sequence) => ['status' => Arr::random(['full-time', 'freelance', 'outsource'])]),


            )->create();


    }
}

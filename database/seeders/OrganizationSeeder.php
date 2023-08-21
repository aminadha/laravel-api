<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Organization A',
                'address' => 'No. 1A, Jalan 1/2',
                'postcode' => '43500',
                'city' => 'Putrajaya',
                'state' => 'Selangor',
            ],
            [
                'name' => 'Organization B',
                'address' => 'No. 1B, Jalan 1/3',
                'postcode' => '43000',
                'city' => 'Cyberjaya',
                'state' => 'Selangor',
            ]
        ];

        foreach ($data as $organization) {
            Organization::updateOrCreate(['name' => $organization['name']], $organization);
        }
    }
}

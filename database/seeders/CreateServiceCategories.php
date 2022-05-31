<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class CreateServiceCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'id' => 1,
                'name' => 'Assistance with Daily Life (Includes SIL)',
            ],
            [
                'id' => 2,
                'name' => 'Transport',
            ],
            [
                'id' => 3,
                'name' => 'Consumables',
            ],
            [
                'id' => 4,
                'name' => 'Assistance with Social, Economic and Community Participation',
            ],
            [
                'id' => 5,
                'name' => 'Assistive Technology',
            ],
            [
                'id' => 6,
                'name' => 'Home Modifications and Specialised Disability Accommodation (SDA)',
            ],
            [
                'id' => 7,
                'name' => 'Support Coordination',
            ],
            [
                'id' => 8,
                'name' => 'Improved Living Arrangements',
            ],
            [
                'id' => 9,
                'name' => 'Increased Social and Community Participation',
            ],
            [
                'id' => 10,
                'name' => 'Finding and Keeping a Job',
            ],
            [
                'id' => 11,
                'name' => 'Improved Relationships',
            ],
            [
                'id' => 12,
                'name' => 'Improved Health and Wellbeing',
            ],
            [
                'id' => 13,
                'name' => 'Improved Learning',
            ],
            [
                'id' => 14,
                'name' => 'Improved Life Choices',
            ],
            [
                'id' => 15,
                'name' => 'Improved Daily Living Skills',
            ],

        ];
        ServiceCategory::upsert($data,['id'],['name']);
    }
}

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
        $data = [
            [
                'id' => 1,
                'name' => 'Assistance with Daily Life (Includes SIL)',
                'short_name' => 'Daily Life'
            ],
            [
                'id' => 2,
                'name' => 'Transport',
                'short_name' => 'Transport'
            ],
            [
                'id' => 3,
                'name' => 'Consumables',
                'short_name' => 'Consumables'
            ],
            [
                'id' => 4,
                'name' => 'Assistance with Social, Economic and Community Participation',
                'short_name' => 'Community Participation'
            ],
            [
                'id' => 5,
                'name' => 'Assistive Technology',
                'short_name' => 'AT'
            ],
            [
                'id' => 6,
                'name' => 'Home Modifications and Specialised Disability Accommodation (SDA)',
                'short_name' => 'HM and SDA'
            ],
            [
                'id' => 7,
                'name' => 'Support Coordination',
                'short_name' => 'Support Coordination'
            ],
            [
                'id' => 8,
                'name' => 'Improved Living Arrangements',
                'short_name' => 'ILA'
            ],
            [
                'id' => 9,
                'name' => 'Increased Social and Community Participation',
                'short_name' => 'Increased Social'
            ],
            [
                'id' => 10,
                'name' => 'Finding and Keeping a Job',
                'short_name' => 'Job'
            ],
            [
                'id' => 11,
                'name' => 'Improved Relationships',
                'short_name' => 'Improved Relationships'
            ],
            [
                'id' => 12,
                'name' => 'Improved Health and Wellbeing',
                'short_name' => 'Improved Health'
            ],
            [
                'id' => 13,
                'name' => 'Improved Learning',
                'short_name' => 'Improved Learning'
            ],
            [
                'id' => 14,
                'name' => 'Improved Life Choices',
                'short_name' => 'Plan Management'
            ],
            [
                'id' => 15,
                'name' => 'Improved Daily Living Skills',
                'short_name' => 'Therapy'
            ],

        ];
        ServiceCategory::upsert($data,['id'],['name','short_name']);
    }
}

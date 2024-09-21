<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessDisciplineSeeder extends Seeder
{
    public function run()
    {
        $disciplines = [
            'Carriage Pleasure Driving',
            'Combined Driving/Para-Driving',
            'Dressage',
            'Endurance',
            'English Pleasure',
            'Eventing',
            'Hunter',
            'Hunter/Jumping Seat Equitation',
            'Jumping',
            'Para-Equestrian',
            'Parade Horse',
            'Reining',
            'Roadster',
            'Saddle Seat',
            'Vaulting',
            'Western',
            'Western Dressage',
            'Western/Reining Seat Equitation',
        ];

        foreach ($disciplines as $discipline) {
            DB::table('job_listing_disciplines')->updateOrInsert(
                ['name' => $discipline],
                ['name' => $discipline]
            );
        }
    }
}

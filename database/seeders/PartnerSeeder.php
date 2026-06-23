<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for($i=1;$i<=5;$i++){
            Partner::create(['name'=>$faker->company,'url_logo'=>'https://placeholder.co/200x100']);
        }
    }
}

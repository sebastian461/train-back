<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $countries = [
      [
        'name' => 'Ecuador',
        'phone_ext' => '+593',
      ],
      [
        'name' => 'Colombia',
        'phone_ext' => '+57'
      ]
    ];

    DB::table('countries')->insert($countries);
  }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $cities = [
      [
        'country_id' => 1,
        'name' => 'Quito',
      ],
      [
        'country_id' => 1,
        'name' => 'Guayaquil',
      ],
      [
        'country_id' => 2,
        'name' => 'Bogota',
      ],
      [
        'country_id' => 2,
        'name' => 'Cali'
      ]
    ];

    DB::table('cities')->insert($cities);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function city(): HasMany
  {
    return $this->hasMany(City::class);
  }

  public function travelOrigin(): HasMany
  {
    return $this->hasMany(Travel::class, 'country_origin');
  }

  public function travelDestiny(): HasMany
  {
    return $this->hasMany(Travel::class, 'country_destiny');
  }
}

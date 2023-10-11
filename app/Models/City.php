<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function country(): BelongsTo
  {
    return $this->belongsTo(Country::class);
  }

  public function travelOrigin(): HasMany
  {
    return $this->hasMany(Travel::class, 'city_origin');
  }

  public function travelDestiny(): HasMany
  {
    return $this->hasMany(Travel::class, 'city_destiny');
  }
}

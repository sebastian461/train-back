<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Travel extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function train(): BelongsTo
  {
    return $this->belongsTo(Train::class);
  }

  public function countryOrigin(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'country_origin');
  }

  public function cityOrigin(): BelongsTo
  {
    return $this->belongsTo(City::class, 'city_origin');
  }

  public function countryDestiny(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'country_destiny');
  }

  public function cityDestiny(): BelongsTo
  {
    return $this->belongsTo(City::class, 'city_destiny');
  }

  public function user(): BelongsToMany
  {
    return $this->belongsToMany(User::class);
  }
}

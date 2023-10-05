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

  public function cityOrigin(): BelongsTo
  {
    return $this->belongsTo(City::class, 'origin');
  }

  public function cityDestiny(): BelongsTo
  {
    return $this->belongsTo(City::class, 'destiny');
  }

  public function user(): BelongsToMany
  {
    return $this->belongsToMany(User::class);
  }
}

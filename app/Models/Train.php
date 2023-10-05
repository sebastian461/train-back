<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Train extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function travel(): HasMany
  {
    return $this->hasMany(Travel::class);
  }
}

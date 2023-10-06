<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('travel', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('train_id');
      $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
      $table->unsignedBigInteger('country_origin');
      $table->unsignedBigInteger('city_origin');
      $table->unsignedBigInteger('country_destiny');
      $table->unsignedBigInteger('city_destiny');
      $table->foreign('country_origin')->references('id')->on('countries')->onDelete('cascade');
      $table->foreign('city_origin')->references('id')->on('cities')->onDelete('cascade');
      $table->foreign('country_destiny')->references('id')->on('countries')->onDelete('cascade');
      $table->foreign('city_destiny')->references('id')->on('cities')->onDelete('cascade');
      $table->integer('places');
      $table->timestamp('date');
      $table->enum('status', ['wait', 'in progress', 'finalized', 'cancelled']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('travel');
  }
};

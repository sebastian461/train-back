<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TravelJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $date = Carbon::now()->toDateString();
    $time = Carbon::now()->toTimeString();

    DB::table('travel')
      ->where('status', 'in progress')
      ->orWhere('status', 'wait')
      ->whereDate('date', '<', $date)
      ->update(['status' => 'finalized']);

    DB::table('travel')
      ->where('status', 'wait')
      ->whereDate('date', $date)
      ->whereTime('date', '<=', $time)
      ->update(['status' => 'in progress']);
  }
}

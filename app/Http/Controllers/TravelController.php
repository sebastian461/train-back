<?php

namespace App\Http\Controllers;

use App\Jobs\TravelJob;
use App\Models\Train;
use App\Models\Travel;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TravelController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $date = Carbon::now()->toDateString();
    $time = Carbon::now()->toTimeString();
    $travel = DB::table('travel')
      ->where('status', 'wait')
      ->where('places', '>', 0)
      ->whereDate('date', '>=', $date)
      ->whereTime('date', '>=', $time)
      ->get();

    TravelJob::dispatch();

    return response()->json([
      'message' => 'Travels available',
      'travels' => $travel
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $travel = Travel::find($id);

    return response()->json([
      'message' => 'Travel',
      'travel' => $travel
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $travel = Travel::find($id);

    $travel->users()->attach($id, [
      'user_id' => $request->user_id,
      'places' => $request->places
    ]);

    $travel->places = $travel->places - $request->places;
    $travel->save();

    return response()->json([
      'message' => 'Created successfully',
      'travel' => $travel,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}

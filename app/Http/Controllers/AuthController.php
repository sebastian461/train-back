<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    if (!Auth::attempt($request->only('email', 'password'))) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = User::where('email', $request['email'])->firstOrFail();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'message' => 'Hi ' . $user->name,
      'accessToken' => $token,
      'token_type' => 'Bearer',
      'user' => $user,
    ]);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return [
      'message' => 'You have sucessfully logged out',
    ];
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:4'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors());
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    $user->save();

    $user->assignRole('User');

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'message' => 'Hi ' . $user->email,
      'accessToken' => $token,
      'token_type' => 'Bearer',
      'user' => $user,
    ]);
  }
}

<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Wrong credentials'], 422);
    }

    return response()->json([
        'token' => $user->createToken('api')->plainTextToken,
        'user' => new UserResource($user)
    ], 201);
});


Route::middleware(['auth:sanctum'])->group(function () {
    // logout
    Route::delete('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([], 204);
    });

    // user
    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => new UserResource($request->user())
        ]);
    });

    // usuarios
    Route::apiResource('users', UserController::class);
});

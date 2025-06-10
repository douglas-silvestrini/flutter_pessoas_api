<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    // index
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'users' => UserResource::collection($users),
        ]);
    }
}

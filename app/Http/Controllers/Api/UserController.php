<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
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

    // show
    public function show(User $user)
    {
        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    // store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'is_active' => ['required', 'boolean'],
        ]);

        try {
            $validated['password'] = bcrypt('admin');
            $user = User::create($validated);
            return response()->json([
                'user' => new UserResource($user)
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }


    // update
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'is_active' => ['required', 'boolean'],
        ]);

        try {
            $user = $user->update($validated);
            return response()->json([
                'user' => new UserResource($user)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }


    // delete
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([], 204);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}

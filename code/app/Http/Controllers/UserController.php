<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return response()->json(User::all());
    }

    public function create(Request $request) {
        if ($validation = User::validatePayload($request->all(), 'create')) {
            $user = User::create($request->all());
            return response()->json($user->transform(), 201);
        } 
        return response()->json($validation, 400);
    }

    public function read(int $id) {
        return response()->json($id);
    }

    public function update(int $id) {
        return response();
    }

    public function delete(int $id) {
        return response();
    }
}

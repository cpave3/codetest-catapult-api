<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return response()->json(User::all());
    }

    public function create(Request $request) {
        $validator = $this->validate($request, [
            'email'     => 'required|email|unique:users',
            'firstname' => 'required',
            'lastname'  => 'required',
            'password'  => 'required|min:8'
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->password = app('hash')->make($request->get('password'));
        $user->save();
        return response()->json($user->transform(), 201);
    
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

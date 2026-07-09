<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    public function newUser()
    {
        return view('users.create');
    }

    public function newUserSubmit(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('index');
    }

    public function editUserSubmit(Request $request)
    {
        $id = $request->user_id;
        $user = User::find($id);
        $user->username = $request->username;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('index');
    }

    public function updateRoles(User $user, Request $request)
    {
        $input = $request->validate([
            'roles' => 'required|array'
        ]);
        $user->roles()->sync($input['roles']);
        return redirect()->route('perfil');
    }

    public function viewPerfil()
    {
        if (!session('user_id')) {
            $user = User::findOrFail(session('user.id'));
            $roles = Role::all();
            return view('users.perfil', compact('user', 'roles'));
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->to('/login');
    }

    public function listUsers()
    {
        $users = User::all();
        $roles = Role::all();
        return view('users.list_users', compact('users', 'roles'));
    }
}

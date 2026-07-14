<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

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
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login');
    }

    public function editUserSubmit(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        Gate::authorize('updateProfile', $user);

        $user->username = $request->username;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('index');
    }

    public function updateRoles(User $user, Request $request)
    {
        Gate::authorize('manageRoles', User::class);

        $input = $request->validate([
            'roles' => 'required|array'
        ]);
        $user->roles()->sync($input['roles']);
        return redirect()->route('perfil');
    }

    public function viewPerfil()
    {
        if (session('user.id')) {
            $user = User::findOrFail(session('user.id'));
            $roles = Role::all();
            return view('users.perfil', compact('user', 'roles'));
        } else {
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/login');
    }

    public function listUsers()
    {
        Gate::authorize('listUsers', User::class);
        $users = User::all();
        $roles = Role::all();
        return view('users.list_users', compact('users', 'roles'));
    }
}

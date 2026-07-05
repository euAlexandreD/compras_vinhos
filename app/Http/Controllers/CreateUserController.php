<?php

namespace App\Http\Controllers;

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

    public function editUser($id)
    {
        $user = User::find($id);
        return view('users.edit_user', compact('user'));
    }

    public function editUserSubmit(Request $request)
    {
        $id = $request->user_id;
        $user = User::find($id);
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;

        $saved = $user->save();


        return redirect()->route('index');
    }
}

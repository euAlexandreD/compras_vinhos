<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {

        $request->validate(
            [
                'username' => 'required',
                'password' => 'required|min:6|max:16',
            ],
            [
                'username.required' => 'Seu nome é obrigatório',
                'username.username' => 'Seu nome precisa ser um username válido',
                'password.required' => 'password é obrigatório',
                'password.min' => 'password deve ter pelo menos 6 caracteres',
                'password.max' => 'password não deve exceder 16 caracteres',
            ]
        );

        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Credenciais invalidas');
        }

        if ($password != $user->password) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Credenciais invalidas');
        }

        Auth::login($user);
        session([
            'user' => [
                'id' => $user->id,
                'name' => $user->username,
            ]
        ]);
        return redirect()->route('index');
    }
}

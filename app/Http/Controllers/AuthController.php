<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                'email' => 'required|email',
                'password' => 'required|min:6|max:16',
            ],
            [
                'email.required' => 'E-mail é obrigatório',
                'email.email' => 'E-mail precisa ser um email válido',
                'password.required' => 'Password é obrigatório',
                'password.min' => 'Password deve ter pelo menos 6 caracteres',
                'password.max' => 'Password não deve exceder 16 caracteres',
            ]
        );

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)
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

        $user->save();
        session([
            'user' => [
                'id' => $user->id,
                'name' => $user->username,
            ]
        ]);
        return redirect()->route('index');
    }
}

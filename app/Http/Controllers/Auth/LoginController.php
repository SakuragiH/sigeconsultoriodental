<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
       // Solo usuarios con rol 'Usuario'
        if ($user->hasRole('Usuario')) {
            return redirect()->route('usuario.index'); // Portal front usuario
        }

        if ($user->hasRole('Odontologo')) {
        return redirect()->route('odontologo.index'); // ahora apunta a index()
        }

        if ($user->hasRole('Paciente')) {
        return redirect()->route('usuario.index'); // Panel front del paciente
        }
        
        // Administradores van al adminlte
        if ($user->hasRole('Administrador')) {
            return redirect()->route('admin.dashboard'); // Ruta adminlte
        }

        // Otros roles (opcional)
        return redirect('/home');
    }
}

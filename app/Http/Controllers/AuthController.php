<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\ClosedCash;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        // check and add session closed cash
        $idUser = Auth::id();
        $request->session()->put('ClosedCash', $this->ClosedCash($idUser));

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function create()
    {
        return view('pages.signup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'role' => 'Umum',
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // check and add session closed cash
        $idUser = Auth::id();
        $request->session()->put('ClosedCash', $this->ClosedCash($idUser));

        return redirect(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Handle Closed Cashed after login to session
     * @param number ID USER
     * @return string Active Closed id
     */
    public function ClosedCash($idUser)
    {
        $data = ClosedCash::whereNull('closed')->latest()->first();
        if ($data) {
            // jika null maka buat data
            return $data->active;
        }
        $generateClosedCash = md5(now());
        $isi = [
            'active' => $generateClosedCash,
            'user_id' => $idUser,
        ];
        $createData = ClosedCash::create($isi);
        return $generateClosedCash;

    }
}

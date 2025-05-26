<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       // ...
Validator::make($request->all(), [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
    'phone' => ['nullable', 'string', 'max:20', 'unique:'.User::class], // Добавлено
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
])->validate();

$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone, 
    'password' => Hash::make($request->password),
]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
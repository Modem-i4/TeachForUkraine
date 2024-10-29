<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): Response
    {
        $r = $request->query('r');
        $user = Auth::user();
        return Inertia::render('Auth/Register', ['r' => (int)$r, 'name' => $user->name]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
    {
        $request->validate([
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect('/register?r=1');
    }
    public function updateStudent(Request $request): Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|integer|min:1|max:11',
            'oblast' => 'required|string|in:' . implode(',',\App\Constants\Oblasts::LIST),
            'city' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->fill($request->only(['name', 'grade', 'oblast', 'city']));
        $user->save();
        return Inertia::render('Auth/Register', ['r' => 2]);
    }

    public function updateCharacter(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $request->validate([
            'charName' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $user->fill($request->only(['charName']));
        $user->save();
        return Inertia::location(route('dashboard'));
    }
}

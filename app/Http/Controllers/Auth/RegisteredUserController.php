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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request, $step = 'basic'): \Inertia\Response
    {
        $userName = Auth::user()->name ?? '';
        return Inertia::render('Auth/Register', ['step' => $step, 'name' => $userName]);
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
        return redirect('/register/student');
    }

    public function registerStudent(Request $request) :  RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'grade' => 'required|integer|min:1|max:11',
            'oblast' => 'required|string|in:' . implode(',', \App\Constants\Oblasts::LIST),
            'city' => 'required|string|min:3|max:255',
        ]);
        Auth::user()->fill($validatedData)->save();
        return redirect('/register/character');
    }

    public function registerCharacter(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $response = $this->updateCharacter($request);
        if ($response->getStatusCode() === 202) {
            return Inertia::location(route('dashboard'));
        }
        return response()->json(['error' => 'Failed to update character'], 400);
    }
    public function updateCharacter(Request $request) : \Illuminate\Http\Response
    {
        $validatedData = $request->validate([
            'charName' => 'required|string|max:255'
        ]);
        $user = Auth::user();
        $user->fill($validatedData);
        $user->save();
        return response('Character updated successfully', 202);
    }
}

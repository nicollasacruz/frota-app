<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the index profile.
     */
    public function index(Request $request): Response
    {
        $drivers = User::whereJsonContains('roles', 'driver')->get();

        return Inertia::render('Profile/ListDrivers', [
            'drivers' => $drivers,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Profile/Create');
    }

    /**
     * Store the user's profile information.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'min:9', 'max:13'],
            'IBAN' => ['required', 'string', 'max:255'],
            'profitPercentage' => ['required', 'numeric', 'min:1' ,'max:100'],
            'hasCar' => ['required', 'boolean'],
            'rentValue' => ['numeric'],
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $data['roles'] = ['user', 'driver'];

        User::create($data);

        return Redirect::route('dashboard');
    }

    /**
     * Display the user's profile form.
     */
    public function show(User $driver): Response
    {
        return Inertia::render('Profile/ShowDriver', [
            'driver' => $driver,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function editDriver(User $driver): Response
    {
        return inertia('Profile/EditDriver', [
            'driver' => $driver,
        ]);
    }
}

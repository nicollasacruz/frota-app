<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userLogged = User::find(auth()->user()->id);
        if ($userLogged->hasRole('admin')) {
            $users = User::all();
            return inertia('User/Index', [
                'users' => $users,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userLogged = User::find(auth()->user()->id);
        if ($userLogged->hasRole('admin')) {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
                'phone' => 'string',
                'IBAN' => 'string',
                'hasCar' => 'boolean',
                'rentValue' => 'float',
                'profitPercentage' => 'float',
            ]);

            $user = new User();
            $user->fill($request->all());
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('user.index');
        }
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userLogged = User::find(auth()->user()->id);
        if ($userLogged->hasRole('admin')) {
            return inertia('User/Show', [
                'user' => $user,
            ]);
        }
        return redirect()->route('index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userLogged = User::find(auth()->user()->id);
        if ($userLogged->hasRole('admin')) {
            return inertia('User/Edit', [
                'user' => $user,
            ]);
        }
        return redirect()->route('index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string',
            'email' => 'email.unique:users',
            'phone' => 'string',
            'IBAN' => 'string',
            'hasCar' => 'boolean',
            'rentValue' => 'float',
            'profitPercentage' => 'float',
        ]);

        $user->fill($request->all());

        if ($user->isDirty()) {
            $user->save();
        }

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $userLogged = User::find(auth()->user()->id);
        if ($userLogged->hasRole('admin')) {

            $user->delete();
            return redirect()->route('users.index');
        }
    }
}

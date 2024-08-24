<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use App\Models\Partner;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::leftJoin('partners', 'users.partner_id', '=', 'partners.id')
            ->select('users.*', 'partners.name as partner_name', "partners.id as partner_id")
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render('Dashboard/Users/Users', [
            'users' => $users,
        ]);
    }

    public function edit(User $user): Response
    {
        $partners = Partner::select('id', 'name', 'organization')
            ->orderBy('name')
            ->get();

        return Inertia::render('Dashboard/Users/UserEdit', [
            'user' => $user,
            'partners' => $partners
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (!isset($validated['password']) || trim($validated['password']) == '' ) {
           unset($validated['password']);
        }

        if (!Auth::user()->isSysAdmin()) {
            unset($validated['login']);
            unset($validated['role']);
        }

        $user->fill($validated);

        $user->save();

        return to_route('dashboard.users.index');
    }

    public function create(): Response {
        $partners = Partner::select('id', 'name', 'organization')
            ->orderBy('name')
            ->get();

        return Inertia::render('Dashboard/Users/UserCreate', [
            'partners' => $partners
        ]);
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $request->validated();

        $user = User::create([
            'login'       => $request->login,
            'name'        => $request->name,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            "partner_id"  => $request->partner_id,
            "is_disabled" => $request->is_disabled,
        ]);

        event(new Registered($user));

        return to_route('dashboard.users.index');
    }
}

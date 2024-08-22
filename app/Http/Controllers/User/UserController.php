<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
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

        return Inertia::render("Dashboard/Users/Users", [
            "users" => $users,
        ]);
    }

    public function edit(User $user): Response
    {
        $partners = Partner::select("id", "name", "organization")
            ->orderBy("name")
            ->get();

        return Inertia::render("Dashboard/Users/UserEdit", [
            "user" => $user,
            "partners" => $partners
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): Response
    {
        $request = $request->validated();

        $partners = Partner::select("id", "name", "organization")
            ->orderBy("name")
            ->get();

        return Inertia::render("Dashboard/Users/UserEdit", [
            "user" => $user,
            "partners" => $partners
        ]);
    }
}

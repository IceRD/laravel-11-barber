<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::leftJoin('partners', 'users.partner_id', '=', 'partners.id')
            ->select('users.*', 'partners.name as partner_name', "partners.id as partner_id")
            ->orderBy('id', 'DESC')
            ->paginate(250);

        return Inertia::render("Dashboard/Users/Users", [
            "users" => $users,
        ]);
    }
}

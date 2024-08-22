<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{
    public function index(): Response
    {
        $partners = Partner::orderBy('id', 'DESC')
            ->where('disabled', '=', false)
            ->get();

        return Inertia::render("Dashboard/Partners/Partners", [
            "partners" => $partners,
        ]);
    }

    public function edit(Partner $partner): Response
    {
        return Inertia::render("Dashboard/Partners/PartnerEdit", [
            "partner" => $partner
        ]);
    }

    public function update($request, Partner $partner): Response
    {
/*        $request = $request->validated();

        $partners = Partner::select("id", "name", "organization")
            ->orderBy("name")
            ->get();*/

        return Inertia::render("Dashboard/Users/UserEdit", [
            "partner" => $partner
        ]);
    }
}

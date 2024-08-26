<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\PartnerStoreRequest;
use App\Models\Partner;
use App\Models\Call;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{
    public function index(): Response
    {
        $partners = Partner::orderBy('id', 'DESC')
            ->get();

        return Inertia::render("Dashboard/Partners/Partners", [
            "partners" => $partners,
        ]);
    }

    public function edit(Partner $partner): Response
    {
        $telnums = json_decode($partner->telnums, true);

         if (!$telnums) {
            $partner->telnums = [[ "number" => "", "name" => ""]];
        } else {
            $partner->telnums = $telnums;
        }

        return Inertia::render("Dashboard/Partners/PartnerEdit", [
            "partner" => $partner
        ]);
    }

    public function update(CallUpdateRequest $request, Partner $partner): RedirectResponse
    {
        $validated = $request->validated();

        if (!Auth::user()->isSysAdmin()) {
            unset($validated['yclients_id']);
            unset($validated['start_at']);
            unset($validated['disabled']);
        }

        $telnums = array_values(
            array_filter($validated['telnums'], function($v) {
                 return !empty($v['number']);
            })
        );

        $validated['telnums'] = json_encode($telnums);

        $partner->fill($validated);

        $partner->save();

        return to_route('dashboard.partners.index');
    }

    public function create(): Response
    {
        return Inertia::render("Dashboard/Partners/PartnerCreate");
    }

    public function store(PartnerStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $telnums = array_values(
            array_filter($validated['telnums'], function($v) {
                return !empty($v['number']);
            })
        );

        $validated['telnums'] = json_encode($telnums);

        DB::transaction(function () use ($validated) {
            $partner = Partner::create($validated);

            Call::create(['partner_id' => $partner->id]);
        });

        return to_route('dashboard.partners.index');
    }
}

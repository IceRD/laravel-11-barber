<?php

namespace App\Http\Controllers\Call;

use App\Http\Controllers\Controller;
use App\Http\Requests\Call\CallUpdateRequest;
use App\Models\Call;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CallController extends Controller
{
    public function index(): Response
    {
        $calls = Call::leftJoin('partners', 'calls.partner_id', '=', 'partners.id')
            ->select('calls.*', 'partners.name as partner', 'partners.disabled as disabled')
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render("Dashboard/Calls/Calls", [
            "calls" => $calls,
        ]);
    }

    public function edit(Call $call): Response
    {
        return Inertia::render("Dashboard/Calls/CallEdit", [
            "call" => $call
        ]);
    }

    public function update(CallUpdateRequest $request, Call $call): RedirectResponse
    {
        $validated = $request->validated();

        $call->fill($validated);

        $call->save();

        return to_route('dashboard.calls.index');
    }
}

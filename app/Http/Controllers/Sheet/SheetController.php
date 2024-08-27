<?php

namespace App\Http\Controllers\Sheet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sheet\SheetStoreRequest;
use App\Http\Requests\Sheet\SheetUpdateRequest;
use App\Models\Sheet;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SheetController extends Controller
{
    public function index(): Response
    {
        $sheets = Sheet::orderBy('id', 'DESC')
            ->get();

        return Inertia::render("Dashboard/Sheets/Sheets", [
            "sheets" => $sheets ,
        ]);
    }

    public function edit(Sheet $sheet): Response
    {
        return Inertia::render("Dashboard/Sheets/SheetEdit", [
            "sheet" => $sheet
        ]);
    }

    public function update(SheetUpdateRequest $request, Sheet $sheet): RedirectResponse
    {
        $validated = $request->validated();

        $sheet->fill($validated);

        $sheet->save();

        return to_route('dashboard.sheets.index');
    }

    public function create(): Response
    {
        return Inertia::render("Dashboard/Sheets/SheetCreate");
    }

    public function store(SheetStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Sheet::create($validated);

        return to_route('dashboard.sheets.index');
    }

    public function show(Sheet $sheet): Response
    {
        return Inertia::render("Portal/Sheets/Sheet", [
            "sheet" => $sheet
        ]);
    }
}

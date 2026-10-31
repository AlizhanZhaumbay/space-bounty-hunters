<?php

namespace App\Http\Controllers;

use App\Models\HuntLog;
use Illuminate\Http\Request;

class HuntLogController extends Controller
{
    public function index(Request $request)
    {
        $criminalId = $request->validate([
            'criminal_id' => ['nullable', 'integer', 'min:1'],
        ])['criminal_id'] ?? null;

        return HuntLog::query()
            ->when($criminalId !== null, fn ($q) => $q->where('criminal_id', $criminalId))
            ->orderBy('id')
            ->get();
    }

    public function show(int $hunt)
    {
        return HuntLog::query()->findOrFail($hunt);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'criminal_id' => ['required', 'integer', 'exists:wanted_criminals,id'],
            'success' => ['required', 'boolean'],
            'notes' => ['required', 'string', 'max:5000'],
        ]);

        $huntLog = HuntLog::query()->create($data);

        return response()->json($huntLog->refresh(), 201);
    }

    public function update(Request $request, int $hunt)
    {
        $huntLog = HuntLog::query()->findOrFail($hunt);

        $data = $request->validate([
            'success' => ['required_without:notes', 'boolean'],
            'notes' => ['required_without:success', 'string', 'max:5000'],
        ]);

        $huntLog->update($data);

        return $huntLog->refresh();
    }

    public function destroy(int $hunt)
    {
        HuntLog::query()->findOrFail($hunt)->delete();

        return response()->noContent();
    }
}

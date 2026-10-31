<?php

namespace App\Http\Controllers;

use App\Models\WantedCriminal;
use Illuminate\Http\Request;

class WantedCriminalController extends Controller
{
    public function index(Request $request)
    {
        foreach (['armed', 'has_crew', 'escape_master'] as $flag) {
            $value = filter_var($request->query($flag), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($request->filled($flag) && $value !== null) {
                $request->merge([$flag => $value]);
            }
        }

        $filters = $request->validate([
            'min_reward' => ['nullable', 'integer', 'min:0'],
            'max_reward' => ['nullable', 'integer', 'min:0'],
            'armed' => ['nullable', 'boolean'],
            'has_crew' => ['nullable', 'boolean'],
            'escape_master' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'in:reward,-reward'],
        ]);

        return WantedCriminal::query()->applyFilters($filters)->get();
    }

    public function show(int $criminal)
    {
        return WantedCriminal::query()->findOrFail($criminal);
    }
}

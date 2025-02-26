<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\PerformanceBuilder;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): array
    {
        $user_id = $request->has('user_id') ? $request->input('user_id') : null;

        return match ($request->input('type')) {
            'cards' => (new PerformanceBuilder('cards', $user_id))->init(),
            'bar' => (new PerformanceBuilder('bar', $user_id))->init(),
            default => [],
        };

    }
}

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
        return match ($request->input('type')) {
            'cards' => (new PerformanceBuilder('cards'))->init(),
            'bar' => (new PerformanceBuilder('bar'))->init(),
            default => [],
        };

    }
}

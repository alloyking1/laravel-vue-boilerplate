<?php

namespace App\Http\Controllers;

use App\Models\ComingSoon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ComingSoonController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'feature_suggestion' => ['nullable', 'string', 'max:500'],
            'would_pay' => ['nullable', 'in:yes,no'],
            'price_point' => ['nullable', 'string', 'max:50', 'required_if:would_pay,yes'],
        ]);

        ComingSoon::create($payload);

        return back()->with('success', 'Thanks for joining the waitlist.');
    }
}

<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Payment\Contracts\PaymentGatewayInterface;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment::create', [
            'test' => config('payment.test'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PaymentGatewayInterface $gateway)
    {
        $data = $request->validate([
            'plan' => ['required', 'string'],
            'subscription_name' => ['nullable', 'string'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'return_url' => ['nullable', 'url'],
        ]);

        $user = $request->user();

        $checkout = $gateway->createSubscription($user, $data['plan'], [
            'subscription_name' => $data['subscription_name'] ?? 'default',
            'quantity' => $data['quantity'] ?? 1,
            'return_url' => $data['return_url'] ?? null,
            'custom_data' => [
                'source' => 'payment-create-test',
            ],
        ]);

        return view('payment::checkout', [
            'checkout' => $checkout,
            'plan' => $data['plan'],
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('payment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('payment::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}

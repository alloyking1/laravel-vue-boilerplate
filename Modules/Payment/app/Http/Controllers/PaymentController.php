<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Payment\Contracts\PaymentGatewayInterface;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('payment/SubscriptionDashboard', [
            'subscription' => $user->subscriptions()->latest()->first(),
            'transactions' => $user->transactions()->latest()->take(10)->get(),
        ]);
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
        $returnUrl = $data['return_url'] ?: route('payment.success');

        $checkout = $gateway->createSubscription($user, $data['plan'], [
            'subscription_name' => $data['subscription_name'] ?? 'default',
            'quantity' => $data['quantity'] ?? 1,
            'return_url' => $returnUrl,
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
     * Display the checkout success page.
     */
    public function success(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('payment/CheckoutSuccess', [
            'subscription' => $user->subscriptions()->latest()->first(),
            'transaction' => $user->transactions()->latest()->first(),
        ]);
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

    /**
     * Swap the user's subscription plan.
     */
    public function swap(Request $request, PaymentGatewayInterface $gateway)
    {
        $data = $request->validate([
            'plan' => ['required', 'string'],
        ]);

        $user = $request->user();
        $subscription = $user->subscriptions()->where('status', 'active')->latest()->first();

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        $gateway->swapPlan($user, $data['plan']);

        return back()->with('success', 'Plan changed successfully!');
    }

    /**
     * Cancel the user's subscription.
     */
    public function cancel(Request $request, PaymentGatewayInterface $gateway)
    {
        $user = $request->user();
        $subscription = $user->subscriptions()->where('status', 'active')->latest()->first();

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        $gateway->cancel($user);

        return back()->with('success', 'Subscription cancelled. You will have access until the end of your billing period.');
    }

    /**
     * Resume the user's subscription.
     */
    public function resume(Request $request, PaymentGatewayInterface $gateway)
    {
        $user = $request->user();
        $subscription = $user->subscriptions()->latest()->first();

        if (!$subscription || !$subscription->ends_at) {
            return back()->with('error', 'No cancelled subscription found.');
        }

        $gateway->resume($user);

        return back()->with('success', 'Subscription resumed successfully!');
    }
}

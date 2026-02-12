<x-payment::layouts.master>
    <div style="max-width: 720px; margin: 40px auto; font-family: Figtree, sans-serif;">
        <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 16px;">Create Subscription (Test)</h1>

        <form method="POST" action="{{ route('payment.store') }}" style="display: grid; gap: 12px;">
            @csrf

            <input type="hidden" name="plan" value="{{ $test['plan'] ?? '' }}" />
            <input type="hidden" name="subscription_name" value="{{ $test['subscription_name'] ?? 'default' }}" />
            <input type="hidden" name="quantity" value="{{ $test['quantity'] ?? 1 }}" />
            <input type="hidden" name="return_url" value="{{ $test['return_url'] ?? '' }}" />

            <div style="display: grid; gap: 6px; color: #6b7280; font-size: 14px;">
                <div><strong>Plan:</strong> {{ $test['plan'] ?? 'Not set' }}</div>
                <div><strong>Subscription:</strong> {{ $test['subscription_name'] ?? 'default' }}</div>
                <div><strong>Quantity:</strong> {{ $test['quantity'] ?? 1 }}</div>
                <div><strong>Return URL:</strong> {{ $test['return_url'] ?? 'Not set' }}</div>
            </div>

            <button type="submit" @disabled(empty($test['plan'])) style="padding: 10px 16px; border-radius: 6px; background: #111827; color: #fff; border: none; cursor: pointer;">Create Checkout</button>

            @if (empty($test['plan']))
                <p style="color: #dc2626; font-size: 14px;">Set PADDLE_TEST_PRICE_ID in your .env to enable the button.</p>
            @endif
        </form>
    </div>
</x-payment::layouts.master>

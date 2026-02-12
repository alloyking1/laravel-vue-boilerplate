<x-payment::layouts.master>
    <div style="max-width: 960px; margin: 40px auto; font-family: Figtree, sans-serif;">
        <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 8px;">Checkout</h1>
        <p style="margin-bottom: 16px; color: #6b7280;">Plan: {{ $plan }}</p>

        @paddleJS
        <x-paddle-checkout :checkout="$checkout" />

        <details style="margin-top: 20px;">
            <summary style="cursor: pointer;">Checkout options (debug)</summary>
            <pre style="background: #f3f4f6; padding: 12px; border-radius: 6px; overflow-x: auto;">{{ json_encode($checkout->options(), JSON_PRETTY_PRINT) }}</pre>
        </details>
    </div>
</x-payment::layouts.master>

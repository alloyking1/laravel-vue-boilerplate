<?php

namespace Modules\Payment\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Paddle\Http\Controllers\WebhookController;
use Modules\Payment\Contracts\PaymentGatewayInterface;
use RuntimeException;

class PaddleGateway implements PaymentGatewayInterface
{
    public function createSubscription(User $user, string $plan, array $options = []): mixed
    {
        $subscriptionName = $options['subscription_name'] ?? 'default';
        $quantity = (int) ($options['quantity'] ?? 1);
        $customData = array_merge($options['custom_data'] ?? [], [
            'subscription_type' => $subscriptionName,
        ]);

        $checkout = $user->checkout([$plan => $quantity])->customData($customData);

        if (! empty($options['return_url'])) {
            $checkout->returnTo($options['return_url']);
        }

        return $checkout;
    }

    public function swapPlan(User $user, string $subscriptionName, string $plan, array $options = []): mixed
    {
        $subscription = $user->subscription($subscriptionName);

        if (! $subscription) {
            throw new RuntimeException("Subscription [{$subscriptionName}] not found.");
        }

        $swapOptions = $options['options'] ?? [];

        if (! empty($options['invoice'])) {
            return $subscription->swapAndInvoice($plan, $swapOptions);
        }

        return $subscription->swap($plan, $swapOptions);
    }

    public function cancel(User $user, string $subscriptionName, bool $immediately = false): mixed
    {
        $subscription = $user->subscription($subscriptionName);

        if (! $subscription) {
            throw new RuntimeException("Subscription [{$subscriptionName}] not found.");
        }

        return $subscription->cancel($immediately);
    }

    public function resume(User $user, string $subscriptionName): mixed
    {
        $subscription = $user->subscription($subscriptionName);

        if (! $subscription) {
            throw new RuntimeException("Subscription [{$subscriptionName}] not found.");
        }

        return $subscription->resume();
    }

    public function currentSubscription(User $user, string $subscriptionName = 'default'): mixed
    {
        return $user->subscription($subscriptionName);
    }

    public function handleWebhook(array $payload, array $headers = []): mixed
    {
        $request = request();

        if (! $request instanceof Request) {
            $request = Request::create('/payment/webhook', 'POST', $payload);

            foreach ($headers as $key => $values) {
                $request->headers->set($key, is_array($values) ? implode(',', $values) : $values);
            }
        }

        return app(WebhookController::class)($request);
    }
}

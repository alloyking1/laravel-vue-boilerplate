<?php

namespace Modules\Payment\Services;

use App\Models\User;
use Modules\Payment\Contracts\PaymentGatewayInterface;

class StripeGateway implements PaymentGatewayInterface
{
    public function createSubscription(User $user, string $plan, array $options = []): mixed
    {
        throw new \BadMethodCallException('Stripe gateway not implemented yet.');
    }

    public function swapPlan(User $user, string $subscriptionName, string $plan, array $options = []): mixed
    {
        throw new \BadMethodCallException('Stripe gateway not implemented yet.');
    }

    public function cancel(User $user, string $subscriptionName, bool $immediately = false): mixed
    {
        throw new \BadMethodCallException('Stripe gateway not implemented yet.');
    }

    public function resume(User $user, string $subscriptionName): mixed
    {
        throw new \BadMethodCallException('Stripe gateway not implemented yet.');
    }

    public function currentSubscription(User $user, string $subscriptionName = 'default'): mixed
    {
        throw new \BadMethodCallException('Stripe gateway not implemented yet.');
    }

    public function handleWebhook(array $payload, array $headers = []): mixed
    {
        throw new \BadMethodCallException('Stripe gateway not implemented yet.');
    }
}

<?php

namespace Modules\Payment\Contracts;

use App\Models\User;

interface PaymentGatewayInterface
{
    public function createSubscription(User $user, string $plan, array $options = []): mixed;

    public function swapPlan(User $user, string $subscriptionName, string $plan, array $options = []): mixed;

    public function cancel(User $user, string $subscriptionName, bool $immediately = false): mixed;

    public function resume(User $user, string $subscriptionName): mixed;

    public function currentSubscription(User $user, string $subscriptionName = 'default'): mixed;

    public function handleWebhook(array $payload, array $headers = []): mixed;
}

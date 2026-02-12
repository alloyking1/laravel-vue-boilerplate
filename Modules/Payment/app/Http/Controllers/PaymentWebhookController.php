<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Payment\Contracts\PaymentGatewayInterface;

class PaymentWebhookController
{
    public function __invoke(Request $request, PaymentGatewayInterface $gateway)
    {
        return $gateway->handleWebhook($request->all(), $request->headers->all());
    }
}

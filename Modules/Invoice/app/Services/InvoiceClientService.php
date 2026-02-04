<?php

namespace Modules\Invoice\Services;

use Modules\Invoice\Models\InvoiceClient;

class InvoiceClientService
{
    public function create(array $data): InvoiceClient
    {
        return InvoiceClient::create($data);
    }

    public function update(InvoiceClient $client, array $data): InvoiceClient
    {
        $client->update($data);

        return $client;
    }
}

<?php

namespace Modules\Invoice\Services;

use Modules\Invoice\Models\InvoiceSender;

class InvoiceSenderService
{
    public function create(array $data): InvoiceSender
    {
        return InvoiceSender::create($data);
    }

    public function update(InvoiceSender $sender, array $data): InvoiceSender
    {
        $sender->update($data);

        return $sender;
    }
}

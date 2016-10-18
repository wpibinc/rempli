<?php

namespace App\Events;

use App\Events\Event;
use App\Invoice;
use Illuminate\Queue\SerializesModels;

class SmsEvent extends Event
{
    use SerializesModels;

    public $invoice;

    /**
     * SmsEvent constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
}

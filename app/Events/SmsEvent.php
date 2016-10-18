<?php

namespace App\Events;

use App\Events\Event;
use App\Invoice;
use App\User;
use Illuminate\Queue\SerializesModels;

class SmsEvent extends Event
{
    use SerializesModels;

    public $invoice;

    /**
     * SmsEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

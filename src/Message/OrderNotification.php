<?php

namespace App\Message;

class OrderNotification
{
    public function __construct(private int $order_id)
    {
    }
    public function getOrder(): int {
        return $this->order_id;
    }
}

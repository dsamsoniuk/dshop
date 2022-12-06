<?php

namespace App\Order;

use App\Dto\OrderDto;
use Symfony\Component\HttpFoundation\Request;

interface StageInterface
{
    public function getData(): array;
    public function getTemplate():string;
    public function process(Request $request, OrderDto $order): OrderDto;
    public function setComplite(OrderDto $order): void;
    public function isComplite(): bool;
}

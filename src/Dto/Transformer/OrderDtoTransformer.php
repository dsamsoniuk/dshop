<?php

namespace App\Dto\Transformer;

use App\Dto\OrderDto;
use App\Entity\Order;
use App\Repository\BasketRepository;

class OrderDtoTransformer
{
    public function __construct(
        private BasketRepository $basketRepository
    )
    { }
    
    public function transformToObject(OrderDto $orderDto): Order {

        $order = new Order();
        $basket = $this->basketRepository->find($orderDto->getBasket());
        $order->setBasket($basket);

        return $order;
    }
}

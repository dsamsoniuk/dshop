<?php

namespace App\Dto\Transformer;

use App\Dto\OrderDto;
use App\Entity\Order;
use App\Repository\AddressRepository;
use App\Repository\BasketRepository;
use App\Repository\PaymentRepository;

class OrderDtoTransformer
{
    public function __construct(
        private BasketRepository $basketRepository,
        private PaymentRepository $paymentRepository,
        private AddressRepository $addressRepository
    )
    { }

    public function transformToObject(OrderDto $orderDto): Order {

        $order      = new Order();

        $basket     = $this->basketRepository->find($orderDto->getBasket());
        $payment    = $this->paymentRepository->find($orderDto->getPayment());
        $address    = $this->addressRepository->find($orderDto->getAddressDelivery());

        $order->setBasket($basket);
        $order->setDeliveryAddress($address);
        $order->setPayment($payment);

        return $order;
    }
}

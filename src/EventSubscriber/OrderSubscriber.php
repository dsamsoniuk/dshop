<?php

namespace App\EventSubscriber;

use App\Event\CreateOrderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() {
        return [
            CreateOrderEvent::class => 'onCreateOrder'
        ];
    }
    public function onCreateOrder(CreateOrderEvent $event){
        $order = $event->getOrder();
        $a = 1;
    }
}

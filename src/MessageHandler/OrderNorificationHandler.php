<?php

namespace App\MessageHandler;

use App\Entity\Notification;
use App\Entity\Order;
use App\Message\OrderNotification;
use App\Repository\OrderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;

#[AsMessageHandler]
class OrderNorificationHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $orderRepository
        )
    {
    }
    public function __invoke(OrderNotification $orderNotification)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($orderNotification->getOrder());
        $user = $order->getBasket()->getUser();

        $notific = new Notification();
        $notific->setTitle('Order created.');
        $notific->setMessage('Order has been sended to the shop.');
        $user->addNotification($notific);
        
        $this->em->persist($notific);
        $this->em->flush();

    }
}

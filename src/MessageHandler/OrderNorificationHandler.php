<?php

namespace App\MessageHandler;

use App\Entity\Notification;
use App\Entity\Order;
use App\Message\OrderNotification;
use App\Repository\OrderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

#[AsMessageHandler]
class OrderNorificationHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $orderRepository,
        private MailerInterface $mailer
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

        $mail = (new Email())
            ->from('admin@dshop.com')
            ->to($user->getEmail())
            ->subject('Order complite')
            ->text('Order has been sended to the shop.')
            ->html('<p>See ')
            ;
        $this->mailer->send($mail);

    }
}

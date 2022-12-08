<?php

namespace App\Controller\Web;

use App\Dto\OrderDto;
use App\Dto\Transformer\OrderDtoTransformer;
use App\Event\CreateOrderEvent;
use App\Message\OrderNotification;
use App\Order\OrderBuilder;
use App\Service\BasketService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(
        Request $request, 
        SessionInterface $session,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        OrderBuilder $orderBuilder, 
        BasketService $basketService,
        OrderDtoTransformer $orderDtoTransformer,
        EventDispatcherInterface $dispatcher,
        MessageBusInterface $messager
        ): Response
    {

        $basket = $basketService->getBasket();

        if ($session->get('order') instanceof OrderDto) {
            $order = $session->get('order');
        } else {
            $order  = new OrderDto();
        }

        $order->setBasket($basket->getId());

        $orderBuilder->setOrder($order);
        $orderBuilder->process($request);
        $order = $orderBuilder->getOrder();

        $session->set('order', $order);

        if ($orderBuilder->isOrderComplite() && $request->query->getBoolean('create_order')) {

            $newOrder   = $orderDtoTransformer->transformToObject($order);
            $errors     = $validator->validate($newOrder);

            if (count($errors) == 0) {
                $basket = $newOrder->getBasket();
                $basket->setActive(false);
                $em->persist($newOrder);
                $em->flush();
                $session->set('order', null);

                $messager->dispatch(new OrderNotification($newOrder->getId()));
                $this->addFlash('success', 'Order added to queue.');
                //// $event = new CreateOrderEvent($newOrder);
                //// $dispatcher->dispatch($event);
                return $this->redirectToRoute('app_main');

            } else {
                foreach ($errors as $error) {
                    $this->addFlash('danger', $error->getPropertyPath(). ' ' . $error->getMessage());
                    // $this->addFlash('danger', 'Order has error, contact with administration of this page.');
                    // TODO: logger save
                }

            }

            // return $this->redirectToRoute('app_user');
        }


        // }

        $orderStages = $orderBuilder->getStages();

        return $this->render('web/order/index.html.twig', [
            'controller_name' => 'OrderController',
            'order_stages' => $orderStages,
            'order_complite' => $orderBuilder->isOrderComplite()
        ]);
    }
    public function orderAddress(){
        $form = 1;


    }
}

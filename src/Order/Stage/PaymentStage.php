<?php

namespace App\Order\Stage;

use App\Dto\OrderDto;
use App\Form\OrderPaymentType;
use App\Order\StageInterface;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class PaymentStage implements StageInterface
{
    private $template = '_payment.html.twig';
    private $data = [];
    private $complite = false;

    public function __construct(
        private PaymentRepository $paymentRepository,
        private EntityManagerInterface $em,
        private FormFactoryInterface $formFactory
        )
    {}

    public function getTemplate():string {
        return $this->template;
    }

    public function getData(): array{
        return $this->data;
    }

    public function isComplite(): bool{
        return $this->complite;
    }

    public function setComplite(OrderDto $order): void {
        if ($order->getPayment()) {
            $this->complite = true;
        } else {
            $this->complite = false;
        }
    }

    public function process(Request $request, OrderDto $order): OrderDto {

        $payment = $this->paymentRepository->find($order->getPayment() || null);
        $form = $this->formFactory->create(OrderPaymentType::class, [
            'payment' => $payment
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $payment = $form->get('payment')->getData();
            $order->setPayment($payment->getId());
        }

        $this->data['form'] = $form->createView();

        return $order;
    }
}

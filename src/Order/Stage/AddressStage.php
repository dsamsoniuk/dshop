<?php

namespace App\Order\Stage;

use App\Dto\OrderDto;
use App\Entity\Address;
use App\Entity\User;
use App\Form\OrderAddressType;
use App\Order\StageInterface;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class AddressStage implements StageInterface
{
    private $template = '_address.html.twig';
    private $data = [];
    private $complite = false;

    public function __construct(
        private Security $security,
        private FormFactoryInterface $formFactory,
        private AddressRepository $addressRepository,
        private EntityManagerInterface $em
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
        if ($order->getAddressDelivery()) {
            $this->complite = true;
        } else {
            $this->complite = false;
        }
    }

    public function process(Request $request, OrderDto $order): OrderDto {
        /** @var User $user */
        $user = $this->security->getUser();
        
        $deliveryAddresses = $user->getDeliveryAddress();

        if ($order->getAddressDelivery()) {
            $deliveryAddr = $this->addressRepository->find($order->getAddressDelivery());
        } else if (count($deliveryAddresses) > 0) {
            $deliveryAddr = $deliveryAddresses[0];
        } else {
            $deliveryAddr = new Address();
            $deliveryAddr->setUser($user);
        }

        $this->getDeliveryAddressForm($request, $deliveryAddr, $order);

        return $order;
    }

    private function getDeliveryAddressForm(Request $request, Address $address, OrderDto $order){

        $form = $this->formFactory->create(OrderAddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($address, true);
            $this->em->flush();
            $order->setAddressDelivery($address->getId());
        } else if ($form->isSubmitted()) {
            $order->setAddressDelivery(null);
        }

        $this->data['form'] = $form->createView();

    }
}

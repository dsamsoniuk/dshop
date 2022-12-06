<?php

namespace App\Order;

use App\Dto\OrderDto;
use App\Entity\Order;
use App\Order\Stage\AddressStage;
use App\Service\BasketService;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class OrderBuilder
{
    private $stages = [];
    private ?OrderDto $order;
    private $order_complite = true;

    public function __construct(
        private AddressStage $addressStage,
        )
    {
        $this->build();
    }

    public function getStages(): array{
        return $this->stages;
    }

    public function getOrder(): OrderDto {
        return $this->order;
    }

    public function setOrder(OrderDto $order): void {
        $this->order = $order;
    }
    
    public function setOrderComplite($complite = false): void {
        $this->order_complite = $complite;
    }
    public function isOrderComplite(): bool {
        return $this->order_complite;
    }

    private function build(): void{
        $this->addStage($this->addressStage);
    }

    private function addStage(StageInterface $stage): self{
        $this->stages[] = $stage;

        return $this;
    }

    public function process(Request $request) {
        if (!$this->getOrder()) {
            throw new Exception('Order is empty');
        }

        /** @var StageInterface $stage */ 
        foreach ($this->stages as &$stage) {
            $this->order = $stage->process($request, $this->order);

            $stage->setComplite($this->order);
            if (!$stage->isComplite()) {
                $this->setOrderComplite(false);
            }
        }
    }
}

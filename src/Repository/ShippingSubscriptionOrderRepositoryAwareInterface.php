<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Repository;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Core\Repository\OrderItemUnitRepositoryInterface;

interface ShippingSubscriptionOrderRepositoryAwareInterface extends OrderItemUnitRepositoryInterface
{
    /** @return array<int, OrderItemUnitInterface> */
    public function findUnitsWithProductShippingSubscription(OrderInterface $order): array;
}

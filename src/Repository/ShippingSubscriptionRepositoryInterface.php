<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Repository;

use BitBag\SyliusShippingSubscriptionPlugin\Model\ShippingSubscriptionInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;

interface ShippingSubscriptionRepositoryInterface
{
    public function findOneByCode(string $code): ?ShippingSubscriptionInterface;

    public function findOneByOrderItemUnit(OrderItemUnitInterface $orderItemUnit): ?ShippingSubscriptionInterface;
}

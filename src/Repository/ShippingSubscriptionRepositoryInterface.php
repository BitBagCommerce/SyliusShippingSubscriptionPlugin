<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Repository;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ShippingSubscriptionRepositoryInterface
{
    public function findOneByCode(string $code): ?ShippingSubscriptionInterface;

    public function findOneByOrderItemUnit(OrderItemUnitInterface $orderItemUnit): ?ShippingSubscriptionInterface;
}

<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Repository;

use Sylius\Component\Core\Model\OrderInterface;

trait ShippingSubscriptionOrderRepositoryTrait
{
    public function findUnitsWithProductShippingSubscription(OrderInterface $order): array
    {
        $qb = $this->createQueryBuilder('ou')
            ->leftJoin('ou.orderItem', 'oi')
            ->leftJoin('oi.variant', 'v')
            ->leftJoin('v.product', 'p')
            ->andWhere('oi.order = :order')
            ->andWhere('p.shippingSubscription = 1')
            ->setParameter(':order', $order)
        ;

        return $qb->getQuery()->getResult();
    }
}

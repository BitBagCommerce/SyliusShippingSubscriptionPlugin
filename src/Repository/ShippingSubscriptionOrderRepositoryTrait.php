<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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

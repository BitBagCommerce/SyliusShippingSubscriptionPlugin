<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Repository;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;

class ShippingSubscriptionRepository extends EntityRepository implements ShippingSubscriptionRepositoryInterface
{
    public function findOneByCode(string $code): ?ShippingSubscriptionInterface
    {
        /** @var ShippingSubscriptionInterface $subscription */
        $subscription = $this->findOneBy([
            'code' => $code,
        ]);

        return $subscription;
    }

    public function findOneByOrderItemUnit(OrderItemUnitInterface $orderItemUnit): ?ShippingSubscriptionInterface
    {
        /** @var ShippingSubscriptionInterface|null $subscription */
        $subscription = $this->findOneBy([
            'orderItemUnit' => $orderItemUnit,
        ]);

        return $subscription;
    }

    public function findSubscriptionsByOrder(OrderInterface $order): array
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.orderItemUnit', 'u')
            ->leftJoin('u.orderItem', 'oi')
            ->where('oi.order = :order')
            ->setParameter(':order', $order);

        return $qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findActiveSubscription(SubscriptionAwareInterface $customer): ?ShippingSubscriptionInterface
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.expiresAt > s.updatedAt')
            ->andWhere('s.enabled = 1')
            ->andWhere('s.customer = :customer')
            ->setParameter(':customer', $customer)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}

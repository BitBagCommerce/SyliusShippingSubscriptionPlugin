<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Operator;

use BitBag\SyliusShippingSubscriptionPlugin\Factory\ShippingSubscriptionFactory;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionRepositoryInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Core\Model\ProductInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductShippingSubscriptionAwareInterface;

final class OrderShippingSubscriptionOperator
{
    /** @var ShippingSubscriptionFactory */
    private $shippingSubscriptionFactory;

    /** @var ShippingSubscriptionOrderRepositoryAwareInterface */
    private $orderItemUnitRepository;

    /** @var ShippingSubscriptionRepositoryInterface */
    private $shippingSubscriptionRepository;

    /** @var ObjectManager */
    private $manager;

    public function __construct(
        ShippingSubscriptionFactory $shippingSubscriptionFactory,
        ShippingSubscriptionRepositoryInterface $shippingSubscriptionRepository,
        ShippingSubscriptionOrderRepositoryAwareInterface $orderItemUnitRepository,
        ObjectManager $manager
    ) {
        $this->shippingSubscriptionFactory = $shippingSubscriptionFactory;
        $this->shippingSubscriptionRepository = $shippingSubscriptionRepository;
        $this->orderItemUnitRepository = $orderItemUnitRepository;
        $this->manager = $manager;
    }

    public function create(OrderInterface $order): void
    {
        $units = $this->orderItemUnitRepository->findUnitsWithProductShippingSubscription($order);

        if (count($units) === 0) {
            return;
        }

        foreach ($units as $unit) {
            $shippingSubscription = $this->shippingSubscriptionFactory->createFromOrderItemUnit($unit);

            $this->manager->persist($shippingSubscription);
        }

        $this->manager->flush();
    }

    public function enable(OrderInterface $order): void
    {
        $shippingSubscriptions = $this->shippingSubscriptionRepository->findSubscriptionsByOrder($order);

        if (count($shippingSubscriptions) === 0) {
            return;
        }

        foreach ($shippingSubscriptions as $shippingSubscription) {
            $date = (new \DateTime())->modify('+1 year');
            $shippingSubscription->setExpiresAt($date);
            $shippingSubscription->enable();
        }

        $this->manager->flush();
    }

    public function disable(OrderInterface $order): void
    {
        $shippingSubscriptions = $this->shippingSubscriptionRepository->findSubscriptionsByOrder($order);

        if (count($shippingSubscriptions) === 0) {
            return;
        }

        foreach ($shippingSubscriptions as $shippingSubscription) {
            $shippingSubscription->disable();
        }

        $this->manager->flush();
    }

}

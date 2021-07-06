<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Operator;

use BitBag\SyliusShippingSubscriptionPlugin\Factory\ShippingSubscriptionFactory;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionRepositoryInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderShippingSubscriptionOperator
{
    /** @var ShippingSubscriptionFactory */
    private $shippingSubscriptionFactory;

    /** @var ShippingSubscriptionOrderRepositoryAwareInterface */
    private $orderItemUnitRepository;

    /** @var ShippingSubscriptionRepositoryInterface */
    private $shippingSubscriptionRepository;

    /** @var ObjectManager */
    private $shippingSubscriptionManager;

    public function __construct(
        ShippingSubscriptionFactory $shippingSubscriptionFactory,
        ShippingSubscriptionRepositoryInterface $shippingSubscriptionRepository,
        ShippingSubscriptionOrderRepositoryAwareInterface $orderItemUnitRepository,
        ObjectManager $shippingSubscriptionManager
    ) {
        $this->shippingSubscriptionFactory = $shippingSubscriptionFactory;
        $this->shippingSubscriptionRepository = $shippingSubscriptionRepository;
        $this->orderItemUnitRepository = $orderItemUnitRepository;
        $this->shippingSubscriptionManager = $shippingSubscriptionManager;
    }

    public function create(OrderInterface $order): void
    {
        $units = $this->orderItemUnitRepository->findUnitsWithProductShippingSubscription($order);

        if (count($units) === 0) {
            return;
        }

        foreach ($units as $unit) {
            $shippingSubscription = $this->shippingSubscriptionFactory->createFromOrderItemUnit($unit);

            $this->shippingSubscriptionManager->persist($shippingSubscription);
        }

        $this->shippingSubscriptionManager->flush();
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

        $this->shippingSubscriptionManager->flush();
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

        $this->shippingSubscriptionManager->flush();
    }
}

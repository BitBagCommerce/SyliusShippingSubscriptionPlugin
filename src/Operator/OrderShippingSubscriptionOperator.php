<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Operator;

use BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription\SubscriptionLengthCheckerInterface;
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

    /** @var SubscriptionLengthCheckerInterface */
    private $subscriptionLengthChecker;

    public function __construct(
        ShippingSubscriptionFactory $shippingSubscriptionFactory,
        ShippingSubscriptionRepositoryInterface $shippingSubscriptionRepository,
        ShippingSubscriptionOrderRepositoryAwareInterface $orderItemUnitRepository,
        ObjectManager $shippingSubscriptionManager,
        SubscriptionLengthCheckerInterface $subscriptionLengthChecker
    ) {
        $this->shippingSubscriptionFactory = $shippingSubscriptionFactory;
        $this->shippingSubscriptionRepository = $shippingSubscriptionRepository;
        $this->orderItemUnitRepository = $orderItemUnitRepository;
        $this->shippingSubscriptionManager = $shippingSubscriptionManager;
        $this->subscriptionLengthChecker = $subscriptionLengthChecker;
    }

    public function create(OrderInterface $order): void
    {
        if (null === $order->getId()) {
            return;
        }
        $units = $this->orderItemUnitRepository->findUnitsWithProductShippingSubscription($order);

        if (0 === count($units)) {
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
        if (null === $order->getId()) {
            return;
        }
        $shippingSubscriptions = $this->shippingSubscriptionRepository->findSubscriptionsByOrder($order);

        if (0 === count($shippingSubscriptions)) {
            return;
        }

        foreach ($shippingSubscriptions as $shippingSubscription) {
            $length = $this->subscriptionLengthChecker->checkSubscriptionLength($order);
            $date = (new \DateTime())->modify('+' . $length . ' months');
            $shippingSubscription->setExpiresAt($date);
            $shippingSubscription->enable();
        }

        $this->shippingSubscriptionManager->flush();
    }

    public function disable(OrderInterface $order): void
    {
        if (null === $order->getId()) {
            return;
        }
        $shippingSubscriptions = $this->shippingSubscriptionRepository->findSubscriptionsByOrder($order);

        if (0 === count($shippingSubscriptions)) {
            return;
        }

        foreach ($shippingSubscriptions as $shippingSubscription) {
            $shippingSubscription->disable();
        }

        $this->shippingSubscriptionManager->flush();
    }
}

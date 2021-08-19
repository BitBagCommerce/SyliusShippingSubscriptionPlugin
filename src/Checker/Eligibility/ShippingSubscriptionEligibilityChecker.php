<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Eligibility;

use BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription\SubscriptionExpirationCheckerInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionMethodInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Shipping\Checker\Eligibility\ShippingMethodEligibilityCheckerInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;
use Sylius\Component\Shipping\Model\ShippingSubjectInterface;

final class ShippingSubscriptionEligibilityChecker implements ShippingMethodEligibilityCheckerInterface
{
    /** @var SubscriptionExpirationCheckerInterface */
    private $subscriptionExpirationChecker;

    public function __construct(SubscriptionExpirationCheckerInterface $subscriptionExpirationChecker)
    {
        $this->subscriptionExpirationChecker = $subscriptionExpirationChecker;
    }

    public function isEligible(ShippingSubjectInterface $shippingSubject, ShippingMethodInterface $shippingMethod): bool
    {
        if (!$shippingSubject instanceof ShipmentInterface || !$shippingMethod instanceof ShippingSubscriptionMethodInterface) {
            return false;
        }

        return $this->isSubscriptionActive($shippingSubject, $shippingMethod);
    }

    public function isSubscriptionActive(
        ShipmentInterface $shippingSubject,
        ShippingSubscriptionMethodInterface $shippingMethod
    ): bool {
        if (!$this->supports($shippingSubject)) {
            return false;
        }

        if($shippingMethod->isShippingSubscription() !== true){
            return true;
        }

        /** @var OrderInterface $order */
        $order = $shippingSubject->getOrder();

        /** @var SubscriptionAwareInterface $customer */
        $customer = $order->getCustomer();
        if (!$customer) {
            return false;
        }

        $hasActiveSubscription = $this->subscriptionExpirationChecker->checkSubscription($customer);

        $orderHasMinimumTotal = $order->getTotal() >= $shippingMethod->getAvailableFromTotal();

        if ($shippingMethod->isShippingSubscription() && !$hasActiveSubscription) {
            return false;
        }
        if ($shippingMethod->isShippingSubscription() && !$orderHasMinimumTotal) {
            return false;
        }

        return true;
    }

    private function supports(ShippingSubjectInterface $subject): bool
    {
        return $subject instanceof ShipmentInterface &&
            null !== $subject->getOrder()
            ;
    }
}

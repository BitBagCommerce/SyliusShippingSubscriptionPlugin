<?php
declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Eligibility;

use BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription\SubscriptionExpirationCheckerInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingMethodInterface as CustomShippingInterface;
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
        return $this->isSubscriptionActive($shippingSubject, $shippingMethod);
    }
    private function isSubscriptionActive(
        ShippingSubjectInterface $shippingSubject,
        ShippingMethodInterface $shippingMethod
    ): bool {
        /** @var ShipmentInterface $shippingSubject */
        if(!$this->supports($shippingSubject)) {
            return false;
        }

        /** @var OrderInterface $order */
        $order = $shippingSubject->getOrder();

        /** @var SubscriptionAwareInterface $customer */
        $customer = $order->getCustomer();
        if(!$customer){
            return false;
        }

        $hasActiveSubscription = $this->subscriptionExpirationChecker->checkSubscription($customer);

        /** @var CustomShippingInterface $shippingMethod */
        if($shippingMethod->isShippingSubscription() && !$hasActiveSubscription){
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

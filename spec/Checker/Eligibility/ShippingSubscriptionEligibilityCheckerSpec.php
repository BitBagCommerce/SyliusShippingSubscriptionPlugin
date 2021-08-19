<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusShippingSubscriptionPlugin\Checker\Eligibility;

use BitBag\SyliusShippingSubscriptionPlugin\Checker\Eligibility\ShippingSubscriptionEligibilityChecker;
use BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription\SubscriptionExpirationCheckerInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionMethodInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;
use Sylius\Component\Shipping\Model\ShippingSubjectInterface;


final class ShippingSubscriptionEligibilityCheckerSpec extends ObjectBehavior
{
    function let(
        SubscriptionExpirationCheckerInterface $subscriptionExpirationChecker
    ): void {
        $this->beConstructedWith($subscriptionExpirationChecker);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingSubscriptionEligibilityChecker::class);
    }

    function it_is_eligible(ShippingSubjectInterface $shippingSubject, ShippingMethodInterface $shippingMethod)
    {
        $this->isEligible($shippingSubject, $shippingMethod)->shouldReturn(false);
    }

    function it_should_not_support_empty_order(ShipmentInterface $shippingSubject, ShippingSubscriptionMethodInterface $shippingMethod)
    {
        $this->isSubscriptionActive($shippingSubject, $shippingMethod)->shouldReturn(false);
    }

    function it_should_not_display_shipping_method_without_subscription(
        ShipmentInterface $shippingSubject,
        ShippingSubscriptionMethodInterface $shippingMethod,
        OrderInterface $order,
        SubscriptionAwareInterface $customer,
        SubscriptionExpirationCheckerInterface $subscriptionExpirationChecker
    )
    {
        $order->getCustomer()->willReturn($customer);
        $order->getTotal()->willReturn(20000);


        $shippingSubject->getOrder()->willReturn($order);

        $subscriptionExpirationChecker->checkSubscription($customer)->willReturn(false);

        $shippingMethod->getAvailableFromTotal()->willReturn(20000);
        $shippingMethod->isShippingSubscription()->willReturn(true);

        $this->isSubscriptionActive($shippingSubject, $shippingMethod)->shouldReturn(false);

    }

    function it_should_not_display_shipping_method_without_minimum_order_total(
        ShipmentInterface $shippingSubject,
        ShippingSubscriptionMethodInterface $shippingMethod,
        OrderInterface $order,
        SubscriptionAwareInterface $customer,
        SubscriptionExpirationCheckerInterface $subscriptionExpirationChecker
    )
    {
        $order->getCustomer()->willReturn($customer);
        $order->getTotal()->willReturn(19999);


        $shippingSubject->getOrder()->willReturn($order);

        $subscriptionExpirationChecker->checkSubscription($customer)->willReturn(true);

        $shippingMethod->getAvailableFromTotal()->willReturn(20000);
        $shippingMethod->isShippingSubscription()->willReturn(true);

        $this->isSubscriptionActive($shippingSubject, $shippingMethod)->shouldReturn(false);

    }

    function it_should_display_shipping_method_if_subscription_is_not_required(
        ShipmentInterface $shippingSubject,
        ShippingSubscriptionMethodInterface $shippingMethod,
        OrderInterface $order,
        SubscriptionAwareInterface $customer,
        SubscriptionExpirationCheckerInterface $subscriptionExpirationChecker
    )
    {
        $order->getCustomer()->willReturn($customer);
        $order->getTotal()->willReturn(19999);

        $shippingSubject->getOrder()->willReturn($order);

        $subscriptionExpirationChecker->checkSubscription($customer)->willReturn(false);

        $shippingMethod->getAvailableFromTotal()->willReturn(20000);
        $shippingMethod->isShippingSubscription()->willReturn(false);

        $this->isSubscriptionActive($shippingSubject, $shippingMethod)->shouldReturn(true);
    }

    function it_should_display_shipping_method_if_customer_has_subscription_and_minimum_order_total(
        ShipmentInterface $shippingSubject,
        ShippingSubscriptionMethodInterface $shippingMethod,
        OrderInterface $order,
        SubscriptionAwareInterface $customer,
        SubscriptionExpirationCheckerInterface $subscriptionExpirationChecker
    )
    {
        $order->getCustomer()->willReturn($customer);
        $order->getTotal()->willReturn(20000);

        $shippingSubject->getOrder()->willReturn($order);

        $subscriptionExpirationChecker->checkSubscription($customer)->willReturn(true);

        $shippingMethod->getAvailableFromTotal()->willReturn(20000);
        $shippingMethod->isShippingSubscription()->willReturn(true);

        $this->isSubscriptionActive($shippingSubject, $shippingMethod)->shouldReturn(true);
    }

}

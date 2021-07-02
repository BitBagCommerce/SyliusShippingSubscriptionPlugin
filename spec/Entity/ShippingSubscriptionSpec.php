<?php

namespace spec\BitBag\SyliusShippingSubscriptionPlugin\Entity;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscription;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

class ShippingSubscriptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingSubscription::class);
    }

    function it_is_resource(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_implements_shipping_subscription_interface(): void
    {
        $this->shouldImplement(ShippingSubscriptionInterface::class);
    }

}

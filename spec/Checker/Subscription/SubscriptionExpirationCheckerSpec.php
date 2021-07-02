<?php

namespace spec\BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

use BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription\SubscriptionExpirationChecker;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use PhpSpec\ObjectBehavior;

class SubscriptionExpirationCheckerSpec extends ObjectBehavior
{
    function let(ShippingSubscriptionRepositoryInterface $customerRepository): void
    {
        $this->beConstructedWith($customerRepository);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionExpirationChecker::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    function it_should_return_bool(SubscriptionAwareInterface $customer)
    {
        $this->checkSubscription($customer)->shouldBeBool();
    }
}

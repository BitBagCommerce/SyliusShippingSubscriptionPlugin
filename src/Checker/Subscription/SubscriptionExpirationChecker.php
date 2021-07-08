<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

final class SubscriptionExpirationChecker implements SubscriptionExpirationCheckerInterface
{
    /** @var ShippingSubscriptionRepositoryInterface */
    private $customerRepository;

    public function __construct(ShippingSubscriptionRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Checks the customer has an active subscription
     *
     * @throws NonUniqueResultException
     */
    public function checkSubscription(SubscriptionAwareInterface $customer): bool
    {
        $subscription = $this->customerRepository->findActiveSubscription($customer);

        return $subscription instanceof ShippingSubscriptionInterface;
    }
}

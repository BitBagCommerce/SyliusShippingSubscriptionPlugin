<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        if (null === $customer->getId()) {
            return false;
        }

        $subscription = $this->customerRepository->findActiveSubscription($customer);

        return $subscription instanceof ShippingSubscriptionInterface;
    }
}

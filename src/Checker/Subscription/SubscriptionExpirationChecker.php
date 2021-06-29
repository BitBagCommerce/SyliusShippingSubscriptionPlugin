<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

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
        $hasActiveSubscription = false;
        $subscription = $this->customerRepository->findActiveSubscription($customer);
        if($subscription){
            $hasActiveSubscription = true;
        }
        return $hasActiveSubscription;
    }
}

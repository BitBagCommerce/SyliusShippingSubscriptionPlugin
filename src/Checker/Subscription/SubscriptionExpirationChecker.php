<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\CustomerInterface;

final class SubscriptionExpirationChecker
{
    /** @var CustomerInterface */
    private $customer;

    /**
     * SubscriptionExpirationChecker constructor.
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    public function isSubscriptionActive(): bool
    {
        $hasActiveSubscription = false;
        foreach($this->customer->getSubscriptions() as $subscription)
        {
            $subscriptionStart = $subscription->getUpdatedAt()->format('d-m-Y H:i:s');
            $subscriptionEnd = $subscription->getEndAt()->format('d-m-Y H:i:s');
            if($subscriptionStart <= $subscriptionEnd && $subscription->isEnabled()){
                $hasActiveSubscription = true;
            }
        }
        return $hasActiveSubscription;
    }

}

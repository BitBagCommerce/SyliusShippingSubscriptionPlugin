<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;

interface SubscriptionExpirationCheckerInterface
{
    public function checkSubscription(SubscriptionAwareInterface $customer): bool;
}

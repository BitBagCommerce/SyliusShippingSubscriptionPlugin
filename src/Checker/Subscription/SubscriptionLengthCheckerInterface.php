<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

use Sylius\Component\Core\Model\OrderInterface;

interface SubscriptionLengthCheckerInterface
{
    public function checkSubscriptionLength(OrderInterface $order): int;
}

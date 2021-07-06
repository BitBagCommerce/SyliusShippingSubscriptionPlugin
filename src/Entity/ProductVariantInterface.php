<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

interface ProductVariantInterface
{
    public function getSubscriptionLength(): int;

    public function setSubscriptionLength(int $subscriptionLength): void;
}

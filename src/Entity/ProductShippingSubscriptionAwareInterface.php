<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

interface ProductShippingSubscriptionAwareInterface
{
    public function isShippingSubscription(): bool;

    public function setShippingSubscription(bool $shippingSubscription): void;
}

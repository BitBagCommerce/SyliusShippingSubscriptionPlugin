<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

interface ShippingMethodInterface
{
    public function getAvailableFromTotal(): int;

    public function setAvailableFromTotal(int $availableFromTotal): void;

    public function isShippingSubscription(): bool;

    public function setShippingSubscription(bool $shippingSubscription): void;
}

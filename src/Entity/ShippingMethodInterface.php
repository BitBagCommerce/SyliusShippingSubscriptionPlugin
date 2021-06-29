<?php

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

interface ShippingMethodInterface
{
    public function getAvailableFromTotal(): int;

    public function setAvailableFromTotal(int $availableFromTotal): void;

    public function isShippingSubscription(): bool;

    public function setShippingSubscription(bool $shipping_subscription): void;
}

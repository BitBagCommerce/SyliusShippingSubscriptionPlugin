<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

interface ShippingSubscriptionMethodInterface
{
    public function getAvailableFromTotal(): ?int;

    public function setAvailableFromTotal(?int $availableFromTotal): void;

    public function isShippingSubscription(): ?bool;

    public function setShippingSubscription(?bool $shippingSubscription): void;
}

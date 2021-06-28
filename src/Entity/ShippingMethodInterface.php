<?php

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

interface ShippingMethodInterface
{
    /**
     * @return int
     */
    public function getFromTotal(): int;

    /**
     * @param int $fromTotal
     */
    public function setFromTotal(int $fromTotal): void;

    /**
     * @return bool|null
     */
    public function isShippingSubscription(): bool;

    /**
     * @param bool|null $shipping_subscription
     */
    public function setShippingSubscription(bool $shipping_subscription): void;
}

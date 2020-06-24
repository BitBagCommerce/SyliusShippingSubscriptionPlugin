<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

trait ProductTrait
{
    protected $shippingSubscription = false;

    public function isShippingSubscription(): bool
    {
        return $this->shippingSubscription;
    }

    public function setShippingSubscription(bool $shippingSubscription): void
    {
        $this->shippingSubscription = $shippingSubscription;
    }
}

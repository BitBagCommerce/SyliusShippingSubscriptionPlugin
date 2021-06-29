<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity\Shipping;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingMethodInterface;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

class ShippingMethod extends BaseShippingMethod implements ShippingMethodInterface
{
    /** @var boolean */
    protected $shipping_subscription;

    /** @var integer */
    protected $availableFromTotal;

    public function getAvailableFromTotal(): int
    {
        return $this->availableFromTotal;
    }

    public function setAvailableFromTotal(int $availableFromTotal): void
    {
        $this->availableFromTotal = $availableFromTotal;
    }

    public function isShippingSubscription(): bool
    {
        return $this->shipping_subscription;
    }

    public function setShippingSubscription(bool $shipping_subscription): void
    {
        $this->shipping_subscription = $shipping_subscription;
    }

}

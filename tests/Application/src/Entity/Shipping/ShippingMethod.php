<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity\Shipping;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionMethodInterface;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

class ShippingSubscriptionMethod extends BaseShippingMethod implements ShippingSubscriptionMethodInterface
{
    /** @var boolean */
    protected $shippingSubscription;

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
        return $this->shippingSubscription;
    }

    public function setShippingSubscription(bool $shippingSubscription): void
    {
        $this->shippingSubscription = $shippingSubscription;
    }

}

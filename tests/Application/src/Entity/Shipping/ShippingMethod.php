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
    protected $fromTotal;

    /**
     * @return int
     */
    public function getFromTotal(): int
    {
        return $this->fromTotal;
    }

    /**
     * @param int $fromTotal
     */
    public function setFromTotal(int $fromTotal): void
    {
        $this->fromTotal = $fromTotal;
    }

    /**
     * @return bool|null
     */
    public function isShippingSubscription(): bool
    {
        return $this->shipping_subscription;
    }

    /**
     * @param bool|null $shipping_subscription
     */
    public function setShippingSubscription(bool $shipping_subscription): void
    {
        $this->shipping_subscription = $shipping_subscription;
    }

}

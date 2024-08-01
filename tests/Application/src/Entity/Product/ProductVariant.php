<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity\Product;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductVariantInterface;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    /** @var int|null */
    protected $subscriptionLength;

    public function getSubscriptionLength(): ?int
    {
        return $this->subscriptionLength;
    }

    public function setSubscriptionLength(?int $subscriptionLength): void
    {
        $this->subscriptionLength = $subscriptionLength;
    }
}

<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductTrait as SubscriptionShippingProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct
{
    use SubscriptionShippingProductTrait;
}
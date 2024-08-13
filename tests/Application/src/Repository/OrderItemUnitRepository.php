<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Application\src\Repository;

use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderItemUnitRepository as BaseOrderItemUnitRepository;

final class OrderItemUnitRepository extends BaseOrderItemUnitRepository implements ShippingSubscriptionOrderRepositoryAwareInterface
{
    use ShippingSubscriptionOrderRepositoryTrait;
}

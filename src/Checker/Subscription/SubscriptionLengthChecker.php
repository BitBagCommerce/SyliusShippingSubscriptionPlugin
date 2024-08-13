<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Checker\Subscription;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductVariantInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryAwareInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class SubscriptionLengthChecker implements SubscriptionLengthCheckerInterface
{
    /** @var ShippingSubscriptionOrderRepositoryAwareInterface */
    private $orderItemUnitRepository;

    public function __construct(ShippingSubscriptionOrderRepositoryAwareInterface $orderItemUnitRepository)
    {
        $this->orderItemUnitRepository = $orderItemUnitRepository;
    }

    public function checkSubscriptionLength(OrderInterface $order): int
    {
        $units = $this->orderItemUnitRepository->findUnitsWithProductShippingSubscription($order);

        if (0 === count($units)) {
            return 0;
        }

        foreach ($units as $unit) {
            /** @var OrderItemInterface $item */
            $item = $unit->getOrderItem();
            /** @var ProductVariantInterface $variant */
            $variant = $item->getVariant();

            return $variant->getSubscriptionLength();
        }

        return 0;
    }
}

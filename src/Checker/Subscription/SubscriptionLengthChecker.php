<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

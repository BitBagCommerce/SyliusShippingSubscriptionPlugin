<?php

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
        return 0;
        //$units = $this->orderItemUnitRepository->findUnitsWithProductShippingSubscription($order);

        if (count($units) === 0) {
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

<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Shipping\Calculator;

use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Webmozart\Assert\Assert;

final class SubscriptionShippingCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        Assert::isInstanceOf($subject, \Sylius\Component\Core\Model\ShipmentInterface::class);

        $amount = (int) $configuration['amount'];
        $minimumFreeShippingAmount = (int) $configuration['min_amount'];

        /** @var \Sylius\Component\Core\Model\ShipmentInterface $subject*/
        $customer = $subject->getOrder()->getCustomer();
        $orderTotal = $subject->getOrder()->getItemsTotal();

        return $amount;
    }

    public function getType(): string
    {
        return 'subscription_shipping';
    }
}

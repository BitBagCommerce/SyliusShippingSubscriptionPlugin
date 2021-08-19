<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Factory;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use Ramsey\Uuid\Uuid;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Webmozart\Assert\Assert;

final class ShippingSubscriptionFactory implements FactoryInterface
{
    /** @var FactoryInterface */
    private $decoratedFactory;

    public function __construct(FactoryInterface $decoratedFactory)
    {
        $this->decoratedFactory = $decoratedFactory;
    }

    public function createNew(): ShippingSubscriptionInterface
    {
        return $this->decoratedFactory->createNew();
    }

    public function createForChannel(ChannelInterface $channel): ShippingSubscriptionInterface
    {
        $shippingSubscription = $this->createNew();
        $shippingSubscription->setChannel($channel);

        return $shippingSubscription;
    }

    public function createFromOrderItemUnit(OrderItemUnitInterface $orderItemUnit): ShippingSubscriptionInterface
    {
        /** @var OrderInterface|null $order */
        $order = $orderItemUnit->getOrderItem()->getOrder();

        Assert::isInstanceOf($order, OrderInterface::class);

        /** @var ChannelInterface|null $channel */
        $channel = $order->getChannel();

        Assert::isInstanceOf($channel, ChannelInterface::class);

        /** @var CustomerInterface|null $customer */
        $customer = $order->getCustomer();
        Assert::isInstanceOf($customer, CustomerInterface::class);

        /** @var ShippingSubscriptionInterface $shippingSubscription */
        $shippingSubscription = $this->createNew();
        $shippingSubscription->setCode(Uuid::uuid4()->toString());
        $shippingSubscription->setCustomer($customer);
        $shippingSubscription->setOrderItemUnit($orderItemUnit);
        $shippingSubscription->setChannel($channel);
        $shippingSubscription->setEnabled(false);

        return $shippingSubscription;
    }
}

<?php

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

class ShippingSubscriptionFactory implements \Sylius\Component\Resource\Factory\FactoryInterface
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

        $shippingSubscription = $this->createNew();
        $shippingSubscription->setCode(Uuid::uuid4()->toString());
        $shippingSubscription->setCustomer($customer);
        $shippingSubscription->setOrderItemUnit($orderItemUnit);
        $shippingSubscription->setChannel($channel);
        $shippingSubscription->enable();

        return $shippingSubscription;
    }
}

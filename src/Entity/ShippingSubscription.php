<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;

class ShippingSubscription implements ShippingSubscriptionInterface
{
    use TimestampableTrait;
    use ToggleableTrait;

    /** @var int */
    protected $id;

    /** @var OrderItemUnitInterface|null */
    protected $orderItemUnit;

    /** @var CustomerInterface|null */
    protected $customer;

    /** @var string|null */
    protected $code;

    /** @var ChannelInterface */
    protected $channel;

    /** @var \DateTimeInterface|null */
    protected $expiresAt;

    public function __construct()
    {
    }

    public function __toString(): string
    {
        return (string) $this->code;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeInterface $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDeletable(): bool
    {
        return null === $this->orderItemUnit;
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    public function getOrder(): ?OrderInterface
    {
        $orderItemUnit = $this->getOrderItemUnit();
        if (null === $orderItemUnit) {
            return null;
        }

        /** @var OrderInterface|null $order */
        $order = $orderItemUnit->getOrderItem()->getOrder();
        if (null === $order) {
            return null;
        }

        return $order;
    }

    public function getOrderItemUnit(): ?OrderItemUnitInterface
    {
        return $this->orderItemUnit;
    }

    public function setOrderItemUnit(OrderItemUnitInterface $orderItem): void
    {
        $this->orderItemUnit = $orderItem;
    }

    public function getChannelCode(): ?string
    {
        $channel = $this->getChannel();
        if (null === $channel) {
            return null;
        }

        return $channel->getCode();
    }

    public function getChannel(): ?ChannelInterface
    {
        return $this->channel;
    }

    public function setChannel(ChannelInterface $channel): void
    {
        $this->channel = $channel;
    }
}

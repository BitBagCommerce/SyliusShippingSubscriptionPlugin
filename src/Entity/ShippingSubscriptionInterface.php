<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ShippingSubscriptionInterface extends ResourceInterface
{ 
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getId(): ?int;

    public function getCustomer(): ?CustomerInterface;

    public function setCustomer(?CustomerInterface $customer): void;

    public function getOrder(): ?OrderInterface;

    public function getOrderItemUnit(): ?OrderItemUnitInterface;

    public function setOrderItemUnit(OrderItemUnitInterface $orderItem): void;

    public function getChannelCode(): ?string;

    public function getChannel(): ?ChannelInterface;

    public function setChannel(ChannelInterface $channel): void;
}

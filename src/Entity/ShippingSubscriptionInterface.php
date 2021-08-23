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

    public function setEnabled(?bool $enabled): void;

    public function enable(): void;

    public function disable(): void;

    public function setExpiresAt(?\DateTimeInterface $expiresAt): void;

    public function getExpiresAt(): ?\DateTimeInterface;
}

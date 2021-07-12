<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity\Customer;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements SubscriptionAwareInterface
{
    /** @var Collection<int, ShippingSubscriptionInterface>|null */
    protected $shippingSubscriptions;

    /** @return Collection<int, ShippingSubscriptionInterface>|null */
    public function getSubscriptions(): ?Collection
    {
        return $this->shippingSubscriptions;
    }
}


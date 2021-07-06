<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity\Customer;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscription;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements SubscriptionAwareInterface
{
    /** @var Collection|ShippingSubscription[] */
    protected $shippingSubscriptions;

    public function getSubscriptions(): ?Collection
    {
        return $this->shippingSubscriptions;
    }
}

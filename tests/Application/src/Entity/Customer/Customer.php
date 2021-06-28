<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Entity\Customer;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\CustomerInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscription;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements CustomerInterface
{
    /** @var Collection|ShippingSubscription[] */
    protected $shippingSubscriptions;

    /**
     * @return Collection|ShippingSubscription[]
     */
    public function getSubscriptions(): ?PersistentCollection
    {
        return $this->shippingSubscriptions;
    }

}

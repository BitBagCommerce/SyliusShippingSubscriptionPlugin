<?php

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

use Doctrine\ORM\PersistentCollection;

interface CustomerInterface
{
    /**
     * @return PersistentCollection|null
     */
    public function getSubscriptions(): ?PersistentCollection;

}

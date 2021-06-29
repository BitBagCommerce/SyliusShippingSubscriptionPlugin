<?php

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

use Doctrine\ORM\PersistentCollection;

interface SubscriptionAwareInterface
{
    public function getSubscriptions(): ?PersistentCollection;
}

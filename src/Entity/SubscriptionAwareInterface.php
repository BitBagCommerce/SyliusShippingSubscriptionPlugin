<?php

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface SubscriptionAwareInterface
{
    public function getSubscriptions(): ?Collection;
}

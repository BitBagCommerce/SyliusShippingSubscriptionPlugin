<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\CustomerInterface;

interface SubscriptionAwareInterface extends CustomerInterface
{
    public function getSubscriptions(): ?Collection;
}

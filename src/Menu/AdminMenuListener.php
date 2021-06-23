<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addSubscriptionMenu(MenuBuilderEvent $event): void
    {
        $configurationMenu = $event->getMenu()->getChild('sales');
        $configurationMenu
            ->addChild('Subscriptions', ['route' => 'app_admin_shipping_subscription_index'])
            ->setLabel('app.ui.shipping_subscriptions')
            ->setLabelAttribute('icon', 'redo alternate');

    }
}
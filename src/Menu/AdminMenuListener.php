<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addSubscriptionMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        /** @var ItemInterface $salesMenu */
        $salesMenu = $menu->getChild('sales');

        $salesMenu->addChild('Subscriptions', ['route' => 'bitbag_admin_shipping_subscription_index'])
            ->setLabel('bitbag.ui.shipping_subscriptions')
            ->setLabelAttribute('icon', 'redo alternate')
        ;

    }
}
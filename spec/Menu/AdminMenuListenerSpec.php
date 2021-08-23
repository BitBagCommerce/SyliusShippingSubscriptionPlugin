<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusShippingSubscriptionPlugin\Menu;

use BitBag\SyliusShippingSubscriptionPlugin\Menu\AdminMenuListener;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AdminMenuListener::class);
    }

    function it_builds_menu(
        MenuBuilderEvent $event,
        ItemInterface $rootMenuItem,
        ItemInterface $configurationItem,
        ItemInterface $shippingGatewayMenuItem
    ): void {
        $event->getMenu()->willReturn($rootMenuItem);
        $rootMenuItem->getChild('sales')->willReturn($configurationItem);
        $configurationItem
            ->addChild('Subscriptions', ['route' => 'bitbag_sylius_shipping_subscription_plugin_admin_shipping_subscription_index'])
            ->willReturn($shippingGatewayMenuItem)
        ;
        $shippingGatewayMenuItem->setLabel('bitbag_sylius_shipping_subscription_plugin.ui.shipping_subscriptions')->willReturn($shippingGatewayMenuItem);
        $shippingGatewayMenuItem->setLabelAttribute('icon', 'redo alternate')->shouldBeCalled();

        $this->addSubscriptionMenu($event);
    }
}

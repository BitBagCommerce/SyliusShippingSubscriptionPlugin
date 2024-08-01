<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingSubscriptionPlugin\Behat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class StaticWelcomePage extends SymfonyPage implements WelcomePageInterface
{
    /**
     * @inheritdoc
     */
    public function getGreeting(): string
    {
        return $this->getElement('greeting')->getText();
    }

    /**
     * @inheritdoc
     */
    public function getRouteName(): string
    {
        return 'acme_sylius_example_static_welcome';
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'greeting' => '#greeting',
        ]);
    }
}

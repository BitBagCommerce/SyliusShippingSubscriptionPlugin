# Installation

## Overview:
GENERAL
- [Requirements](#requirements)
- [Composer](#composer)
- [Basic configuration](#basic-configuration)
--- 
BACKEND
- [Entities](#entities)
    - [Attribute mapping](#attribute-mapping)
    - [XML mapping](#xml-mapping)
- [Repositories](#repositories)
---
ADDITIONAL
- [Known Issues](#known-issues)
---

## Requirements:
We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.

| Package       | Version         |
|---------------|-----------------|
| PHP           | \>8.0           |
| sylius/sylius | 1.12.x - 1.13.x |
| MySQL         | \>= 5.7         |
| NodeJS        | \>= 18.x        |

## Composer:
```bash
composer require bitbag/name-plugin
```

## Basic configuration:
Add plugin dependencies to your `config/bundles.php` file:

```php
# config/bundles.php

return [
    ...
    BitBag\SyliusShippingSubscriptionPlugin\BitBagSyliusShippingSubscriptionPlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
        
    - { resource: "@BitBagSyliusShippingSubscriptionPlugin/Resources/config/services.xml" }
    - { resource: "@BitBagSyliusShippingSubscriptionPlugin/Resources/config/resources.yml" }
    - { resource: "@BitBagSyliusShippingSubscriptionPlugin/Resources/config/grids.yml" }
```

Add routing to your `config/routes.yaml` file:
```yaml
# config/routes.yaml

bitbag_sylius_shipping_subscription_plugin:
    resource: "@BitBagSyliusShippingSubscriptionPlugin/Resources/config/routing.yml"
```

Add state machine configuration for example to `config/packages/state_machine.yaml`:
```yaml
# config/packages/state_machine.yaml

winzou_state_machine:
    sylius_order:
        callbacks:
            after:
                bitbag_order_cancellation_shipping_subscription:
                    on: [ "cancel" ]
                    do: [ "@bitbag_sylius_shipping_subscription.operator.shipping_subscription", "disable" ]
                    args: [ "object" ]

    sylius_order_checkout:
        callbacks:
            after:
                bitbag_created_shipping_subscription:
                    on: [ "complete" ]
                    do: [ "@bitbag_sylius_shipping_subscription.operator.shipping_subscription", "create" ]
                    args: [ "object" ]

    sylius_order_payment:
        callbacks:
            after:
                bitbag_shipping_subscription_enable:
                    on: [ "pay" ]
                    do: [ "@bitbag_sylius_shipping_subscription.operator.shipping_subscription", "enable" ]
                    args: [ "object" ]
```

## Entities
You can implement entity configuration by using both xml-mapping and attribute-mapping. Depending on your preference, choose either one or the other:
### Attribute mapping
- [Attribute mapping configuration](installation/attribute-mapping.md)
### XML mapping
- [XML mapping configuration](installation/xml-mapping.md)

## Repositories
Add repository with following trait:
```php
<?php
// src/Repository/OrderItemUnitRepository.php

declare(strict_types=1);
    
namespace App\Repository;
    
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Repository\ShippingSubscriptionOrderRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderItemUnitRepository as BaseOrderItemUnitRepository;
    
final class OrderItemUnitRepository extends BaseOrderItemUnitRepository implements ShippingSubscriptionOrderRepositoryAwareInterface
{
    use ShippingSubscriptionOrderRepositoryTrait;
}
```

Override `config/packages/_sylius.yaml` configuration:
```yaml
sylius_order:
    resources:
        order_item_unit:
            classes:
                repository: App\Repository\OrderItemUnitRepository
```

### Update your database
First, please run legacy-versioned migrations by using command:
```bash
bin/console doctrine:migrations:migrate
```

After migration, please create a new diff migration and update database:
```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```
**Note:** If you are running it on production, add the `-e prod` flag to this command.

### Clear application cache by using command:
```bash
bin/console cache:clear
```
**Note:** If you are running it on production, add the `-e prod` flag to this command.

## Templates
Copy required templates into correct directories in your project.

**AdminBundle** (`templates/bundles/SyliusAdminBundle`):
```
vendor/bitbag/shipping-subscription-plugin/tests/Application/templates/bundles/SyliusAdminBundle/Product/Tab/_details.html.twig
vendor/bitbag/shipping-subscription-plugin/tests/Application/templates/bundles/SyliusAdminBundle/ProductVariant/Tab/_details.html.twig
vendor/bitbag/shipping-subscription-plugin/tests/Application/templates/bundles/SyliusAdminBundle/ShippingMethod/_form.html.twig
```

## Known issues
### Translations not displaying correctly
For incorrectly displayed translations, execute the command:
```bash
bin/console cache:clear
```

# XML-mapping

Check the mapping settings in `config/packages/doctrine.yaml` and, if necessary, change them accordingly.
```yaml
doctrine:
    # ...
    orm:
        entity_managers:
            default:
                # ...
                mappings:
                    App:
                        # ...
                        type: xml
                        dir: '%kernel.project_dir%/src/Resources/config/doctrine'
```

Extend entities with parameters and methods using attributes and traits:

- `Product` entity

`src/Entity/Product.php`

```php
<?php 

declare(strict_types=1);
   
namespace App\Entity;
   
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductShippingSubscriptionAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductTrait as SubscriptionShippingProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
   
class Product extends BaseProduct implements ProductShippingSubscriptionAwareInterface
{
    use SubscriptionShippingProductTrait;
}
```

- `ProductVariant` entity

`src/Entity/ProductVariant.php`

```php
<?php

declare(strict_types=1);
    
namespace App\Entity;
    
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductVariantInterface;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    /** @var int|null */
    protected $subscriptionLength;

    public function getSubscriptionLength(): ?int
    {
        return $this->subscriptionLength;
    }

    public function setSubscriptionLength(?int $subscriptionLength): void
    {
        $this->subscriptionLength = $subscriptionLength;
    }
}
```

- `Customer` entity

`src/Entity/Customer.php`

```php
<?php
// src/Entity/Customer.php

declare(strict_types=1);
    
namespace App\Entity;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;    
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
    
class Customer extends BaseCustomer implements SubscriptionAwareInterface
{
    /** @var Collection<int, ShippingSubscriptionInterface>|null */
    protected $shippingSubscriptions;

    /** @return Collection<int, ShippingSubscriptionInterface>|null */
    public function getSubscriptions(): ?Collection
    {
        return $this->shippingSubscriptions;
    }
}
```

- `ShippingMethod` entity

`src/Entity/ShippingMethod.php`

```php
<?php

declare(strict_types=1);
    
namespace App\Entity;
    
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionMethodInterface;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
    
class ShippingMethod extends BaseShippingMethod implements ShippingSubscriptionMethodInterface
{
    /** @var bool|null */
    protected $shippingSubscription;

    /** @var int|null */
    protected $availableFromTotal;

    public function getAvailableFromTotal(): ?int
    {
        return $this->availableFromTotal;
    }

    public function setAvailableFromTotal(?int $availableFromTotal): void
    {
        $this->availableFromTotal = $availableFromTotal;
    }

    public function isShippingSubscription(): ?bool
    {
        return $this->shippingSubscription;
    }

    public function setShippingSubscription(?bool $shippingSubscription): void
    {
        $this->shippingSubscription = $shippingSubscription;
    }
}
```


Define new Entity mapping inside `c` directory.
- `Product` entity

`src/Resources/config/doctrine/Product.orm.xml`
```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
        xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
    <entity name="App\Entity\Product" table="sylius_product">
        <field name="shippingSubscription" type="boolean">
            <options>
                <option name="default">0</option>
            </options>
        </field>
    </entity>
</doctrine-mapping>
```

- `ProductVariant` entity

`src/Resources/config/doctrine/ProductVariant.orm.xml`
```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
    xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
    <entity name="App\Entity\Product\ProductVariant" table="sylius_product_variant">
        <field name="subscriptionLength" type="integer" nullable="true">
            <options>
                <option name="default">0</option>
            </options>
        </field>
    </entity>
</doctrine-mapping>
```

- `Customer` entity

`src/Resources/config/doctrine/Customer.orm.xml`

```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
    xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
   <entity name="App\Entity\Customer\Customer" table="sylius_customer">
      <one-to-many field="shippingSubscriptions" target-entity="BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscription" mapped-by="customer" orphan-removal="true">
      </one-to-many>
   </entity>
</doctrine-mapping>
```

- `ShippingMethod` entity

`src/Resources/config/doctrine/ShippingMethod.orm.xml`

```xml

<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
    xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
    <entity name="App\Entity\Shipping\ShippingMethod" table="sylius_shipping_method">
        <field name="shippingSubscription" type="boolean" nullable="true">
            <options>
                <option name="default">0</option>
            </options>
        </field>
        <field name="availableFromTotal" type="integer" nullable="true">
        </field>
    </entity>
</doctrine-mapping>
```

Override `config/packages/_sylius.yaml` configuration:
```yaml
# config/_sylius.yaml

sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product
        product_variant:
            classes:
                model: App\Entity\ProductVariant

sylius_shipping:
    resources:
        shipping_method:
            classes:
                model: App\Entity\ShippingMethod

sylius_customer:
    resources:
        customer:
            classes:
                model: App\Entity\Customer
```

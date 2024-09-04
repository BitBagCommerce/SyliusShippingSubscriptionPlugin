# Attribute-mapping

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
                        type: attribute
```

Extend entities with parameters and methods using attributes and traits:

- `Product` entity

`src/Entity/Product/Product.php`


```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductShippingSubscriptionAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductTrait as SubscriptionShippingProductTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements ProductShippingSubscriptionAwareInterface
{
    use SubscriptionShippingProductTrait;

    #[ORM\Column(type: 'boolean', options: ["default" => 0])]
    protected $shippingSubscription = false;

    // other methods
}
```

- `ProductVariant` entity

`src/Entity/Product/ProductVariant.php`


```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductVariantInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_product_variant')]
class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 0])]
    protected ?int $subscriptionLength;

    public function getSubscriptionLength(): ?int
    {
        return $this->subscriptionLength;
    }

    public function setSubscriptionLength(?int $subscriptionLength): void
    {
        $this->subscriptionLength = $subscriptionLength;
    }
    
    // other methods
}
```

- `Customer` entity

`src/Entity/Customer/Customer.php`

```php
<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscription;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\SubscriptionAwareInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_customer')]
class Customer extends BaseCustomer implements SubscriptionAwareInterface
{
    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: ShippingSubscription::class, orphanRemoval: true)]
    protected Collection $shippingSubscriptions;

    /** @return Collection<int, ShippingSubscriptionInterface>|null */
    public function getSubscriptions(): ?Collection
    {
        return $this->shippingSubscriptions;
    }
}
```

- `ShippingMethod` entity

`src/Entity/Shipping/ShippingMethod.php`

```php
<?php

declare(strict_types=1);

namespace App\Entity\Shipping;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionMethodInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shipping_method")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_shipping_method')]
class ShippingMethod extends BaseShippingMethod implements ShippingSubscriptionMethodInterface
{
    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => 0])]
    protected ?bool $shippingSubscription;

    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $availableFromTotal;

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
    
    // other methods
}
```

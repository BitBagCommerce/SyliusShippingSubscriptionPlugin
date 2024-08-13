## Attribute mapping settings

### Remember to mark attribute mapping appropriately in the config/doctrine.yaml configuration file.
```
// config/packages/doctrine.yaml

doctrine:
    ...
    orm:
        ...
        mappings:
            App:
                ...
                type: attribute

```
Extend Customer:
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

Extend Product:
```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductShippingSubscriptionAwareInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements ProductShippingSubscriptionAwareInterface
{
    #[ORM\Column(type: 'boolean', options: ["default" => 0])]
    protected bool $shippingSubscription;

    public function isShippingSubscription(): bool
    {
        return $this->shippingSubscription;
    }

    public function setShippingSubscription(bool $shippingSubscription): void
    {
        $this->shippingSubscription = $shippingSubscription;
    }

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }
}
```

Extend ProductVariant:
```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductVariantInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;

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

    protected function createTranslation(): ProductVariantTranslationInterface
    {
        return new ProductVariantTranslation();
    }
}
```

Extend ShippingMethod:
```php
<?php

declare(strict_types=1);

namespace App\Entity\Shipping;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ShippingSubscriptionMethodInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
use Sylius\Component\Shipping\Model\ShippingMethodTranslationInterface;

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
    protected function createTranslation(): ShippingMethodTranslationInterface
    {
        return new ShippingMethodTranslation();
    }
}

```

Extend `OrderItemUnitRepository` (in src/Repository folder): 

```php
<?php
    
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

Add repository path into configuration `config/packages/_sylius.yaml`:

```yaml 
sylius_order:
    resources:
        order_item_unit:
            classes:
                repository: App\Repository\OrderItemUnitRepository
```

### Go back to the main readme and override the Twig files.
[Open Readme](../README.md)

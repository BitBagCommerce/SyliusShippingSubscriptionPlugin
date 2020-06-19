<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" width="55%" alt="BitBag" />
    </a>
    <br />
    
</h1>

## About us

At BitBag we do believe in open source. However, we are able to do it just because of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us working together, feel free to reach us out. You will find out more about our professional services, technologies and contact details at https://bitbag.io/.
## Installation

1. Require plugin with composer:

    ```bash
    composer require bitbag/shipping-subscription-plugin
    ```
 
2. Add plugin dependencies to your `config/bundles.php` file:
    
    ```php
        return [
         ...
        
           BitBag\SyliusShippingSubscriptionPlugin\BitBagSyliusShippingSubscriptionPlugin::class => ['all' => true],
        ];
    ```

3. Import required config in your `config/packages/_sylius.yaml` file:
    
    ```yaml
    # config/packages/_sylius.yaml
    
    imports:
        ...
        
        - { resource: "@BitBagSyliusShippingSubscriptionPlugin/Resources/config/services.xml" }
    ```    

4. Import routing in your `config/routes.yaml` file:
    
    ```yaml
    
    # config/routes.yaml
    ...
    
    bitbag_sylius_product_bundle_plugin:
        resource: "@BitBagSyliusProductBundlePlugin/Resources/config/routing.yml"
    ```

5. Extend `Product`(including Doctrine mapping):

    ```php
    <?php 
   
    declare(strict_types=1);
    
    namespace App\Entity\Product;
    
    use BitBag\SyliusShippingSubscriptionPlugin\Model\ProductTrait as SubscriptionShippingProductTrait;
    use Sylius\Component\Core\Model\Product as BaseProduct;

    class Product extends BaseProduct 
    {
        use SubscriptionShippingProductTrait;  
    }
    ```
   
   Mapping (XML):
   
   ```xml
   <?xml version="1.0" encoding="UTF-8"?>
   <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                     xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                         http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
   >
       <entity name="App\Entity\Product\Product" table="sylius_product">
          <field name="shippingSubscription" type="boolean">
            <options>
                <option name="default">0</option>
            </options>
          </field>
       </entity>
   </doctrine-mapping>
   ```
   
6. Extend `OrderItem` (including Doctrine mapping):

    ```php
   <?php
   
   declare(strict_types=1);
   
   namespace App\Entity\Order;
   
   use BitBag\SyliusProductBundlePlugin\Entity\OrderItemInterface;
   use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemsAwareTrait;
   use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;
   
   class OrderItem extends BaseOrderItem implements OrderItemInterface
   {
   
       use ProductBundleOrderItemsAwareTrait;
   
       public function __construct()
       {
           parent::__construct();
           $this->init();
       }
   
   }
    ```
   
   Mapping (XML):
   
   ```xml
   <?xml version="1.0" encoding="UTF-8"?>
   <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                     xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                         http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
   >
       <entity name="App\Entity\Order\OrderItem" table="sylius_order_item">
           <one-to-many field="productBundleOrderItems" target-entity="BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItem" mapped-by="orderItem" >
               <cascade>
                   <cascade-all/>
               </cascade>
           </one-to-many>
       </entity>
   </doctrine-mapping>
   ```

7. Add configuration for extended product, order item and product variant repository:

    ```yaml
    # config/packages/_sylius.yaml
    sylius_product:
        resources:
            product:
                classes:
                    model: App\Entity\Product\Product
            product_variant:
                classes:
                    repository: BitBag\SyliusProductBundlePlugin\Repository\ProductVariantRepository
   sylius_order:
       resources:
           order_item:
               classes:
                   model: App\Entity\Order\OrderItem
    
    ```

8. Add 'Create/Bundle' to product grid configuration:

    ```yaml
    # config/packages/_sylius.yaml
    
    sylius_grid:
        grids:
            sylius_admin_product:
                actions:
                    main:
                        create:
                            links:
                                bundle:## Usage

                                    label: bitbag_sylius_product_bundle.ui.bundle
                                    icon: plus
                                    route: bitbag_product_bundle_admin_product_create_bundle
    
    ```
    
9. Finish the installation by updating the database schema and installing assets:

    ```
    $ bin/console doctrine:migrations:diff
    $ bin/console doctrine:migrations:migrate
   ```
   
### Running plugin tests

  - PHPUnit

    ```bash
    $ vendor/bin/phpunit
    ```

  - PHPSpec

    ```bash
    $ vendor/bin/phpspec run
    ```

  - Behat (non-JS scenarios)

    ```bash
    $ vendor/bin/behat --tags="~@javascript"
    ```

  - Behat (JS scenarios)
 
    1. Download [Chromedriver](https://sites.google.com/a/chromium.org/chromedriver/)
    
    2. Download [Selenium Standalone Server](https://www.seleniumhq.org/download/).
    
    2. Run Selenium server with previously downloaded Chromedriver:
    
        ```bash
        $ java -Dwebdriver.chrome.driver=chromedriver -jar selenium-server-standalone.jar
        ```
        
    3. Run test application's webserver on `localhost:8080`:
    
        ```bash
        $ (cd tests/Application && bin/console server:run localhost:8080 -d public -e test)
        ```
    
    4. Run Behat:
    
        ```bash
        $ vendor/bin/behat --tags="@javascript"
        ```

### Opening Sylius with your plugin

- Using `test` environment:

    ```bash
    $ (cd tests/Application && bin/console sylius:fixtures:load -e test)
    $ (cd tests/Application && bin/console server:run -d public -e test)
    ```
    
- Using `dev` environment:

    ```bash
    $ (cd tests/Application && bin/console sylius:fixtures:load -e dev)
    $ (cd tests/Application && bin/console server:run -d public -e dev)
    ```

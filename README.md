<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" width="55%" alt="BitBag" />
    </a>
    <br />
    
</h1>

## About us

At BitBag we do believe in open source. However, we are able to do it just because of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us working together, feel free to reach us out. You will find out more about our professional services, technologies and contact details at https://bitbag.io/.
## Usage

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

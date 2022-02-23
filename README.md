# Symfony AR24 Bundle
Client AR24 pour création de LRE

Auteur : Corentin Robardey (crobardey@com-company.fr)
## installation avec composer
ajouter dans composer.json
```bash
    "repositories": [
            {"type": "vcs", "url": "https://github.com/connected-company/symfony-AR24-bundle"},
    ],
```

Exécutez ensuite
```bash
$ composer require connected-company/symfony-ar24-bundle
```
Si vous n'utilisez pas symfony/flex, ajoutez la ligne suivante dans config/bundles.php :
```php
return [
    // ...
    Connected\AR24Bundle\AR24Bundle::class => ['all' => true],
];
```

## configuration

```yaml
    parameters:
        ar24_api_url: "%env(resolve:AR24_URL)%"
        ar24_account_email: "%env(resolve:AR24_ACCOUNT_EMAIL)%"
        ar24_account_token: "%env(resolve:AR24_ACCOUNT_TOKEN)%"

    services:
      App\Bridge\AR24\AR24Client:
        public: true
        autowire: true
        arguments:
          $apiUrl: '%ar24_api_url%'
          $apiAccountName: '%ar24_account_email%'
          $ApiToken: '%ar24_account_token%'

```

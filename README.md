# Mautic Trello Integration
Interact with Trello directly from Mauitc. E.g. create Trello cards for contacts.

# Unit Testing
test

## Mock Server

Uses [prism](https://github.com/stoplightio/prism) to automatically create a mock server based on the OpenAPI specification.

### Start mock server

```
prism mock -d docs/api/i2-trello.oas3.yml
```

### Run tests
```
bin/phpunit --bootstrap vendor/autoload.php --configuration app/phpunit.xml.dist --filter MauticTrelloBundle
```


# Hints

## Symfony Namespace
If you are ever not sure what the actual namespace prefix is then run:
```
bin/console debug:twig
```
## Urls 
http://mautic.ddev.site/s/trello/card/add/1

# Requirements
Mautic v3

# Inspiration
- https://github.com/cdaguerre/php-trello-api
# Mautic Trello Integration
Interact with Trello directly from Mauitc. E.g. create Trello cards for contacts.

![Showing how to create a Trello card from a Mautic contact](https://www.idea2.ch/wp-content/uploads/2020/09/Create-Trello-card-from-Mautic-contact-optimized-c20.gif)

## Requirements
- Mautic v3.0.2
- Trello

## Enduser Documentation
- [English](docs/enduser/docs.en.md)
- [German](docs/enduser/docs.de.md)

# Contributing

## Install OpenAPI generator
```
npm install
```

## Run tests
```
bin/phpunit --bootstrap vendor/autoload.php --configuration app/phpunit.xml.dist --filter Idea2TrelloBundle
```

## API Documentation
The api is based on OpenAPI v3.

- [Overview](Openapi/README.md)

## Enduser documentation
https://github.com/mautic/mautic-documentation/tree/master/pages/12.Plugins/17.Trello


## Mock Server for UnitTests

Can be combined with [prism](https://github.com/stoplightio/prism) to automatically create a mock server based on the OpenAPI specification. This is not in use for now. Static json files are used for the UnitTests.

### Start mock server

```
prism mock -d docs/api/i2-trello.oas3.yml
```
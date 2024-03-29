# Mautic Trello Integration

Interact with Trello directly from Mauitc. E.g. create Trello cards for contacts.

![Showing how to create a Trello card from a Mautic contact](https://www.idea2.ch/wp-content/uploads/2020/09/Create-Trello-card-from-Mautic-contact-optimized-c20.gif)

## Requirements

- [Mautic](https://www.mautic.org) > v3.0.2
- [Trello](https://www.trello.com)
- This plugin is already installed with your [Aivie Mautic Hosting](https://aivie.ch/?utm_source=github&utm_medium=mautic-trello&utm_campaign=opensource&utm_content=hosting)

## Enduser Documentation

- [English](docs/enduser/docs.en.md)
- [German](docs/enduser/docs.de.md)

## See Aivie/Mautic contact data in Trello
There is a companion [Trello Power-UP](https://aivie.ch/mautic-mit-trello-verbinden/?utm_source=github&utm_medium=mautic-trello&utm_campaign=opensource&utm_content=trello-power-up) available to show your latest contact data right inside of Trello.

# Issue? / Feedback? / Feature Requests?

We are always looking for new ways to improve working with Mautic. Please contact us if you have a feature request, or found an issue.

- [Issues](https://github.com/adiux/mautic-trello/issues)
- [Contact](https://aivie.ch/en/contact/?utm_source=github&utm_medium=mautic-trello&utm_campaign=opensource&utm_content=contact)

# Contributing

## Install OpenAPI generator

```
npm install
```

## Run tests

```
bin/phpunit --bootstrap vendor/autoload.php --configuration app/phpunit.xml.dist --filter MauticTrelloBundle
```

## API Documentation

The api is based on OpenAPI v3.

- [Overview](Openapi/README.md)

## Mock Server for UnitTests

Can be combined with [prism](https://github.com/stoplightio/prism) to automatically create a mock server based on the OpenAPI specification. This is not in use for now. Static json files are used for the UnitTests.

### Start mock server

```
prism mock -d docs/api/i2-trello.oas3.yml
```

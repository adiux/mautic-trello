next step: 

1. 

# Apis
1. Call Mautic to add security and create card from Frontend (uses Mautic Frontend Auth /s)
2. Actually create card with Trello API (use the Trello Auth)

# Urls
http://mautic.ddev.site/s/trello/card/add/1

# Hints
And all should be well. If you are ever not sure what the actual namespace prefix is then run:
```
bin/console debug:twig
```

# Requirements
Min PHP 7.0.0

# Inspiration
- https://github.com/cdaguerre/php-trello-api
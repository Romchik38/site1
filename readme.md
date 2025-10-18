# Readme

This is an example site to show how [php-server](https://github.com/Romchik38/server) and [php-container](https://github.com/Romchik38/php-container) works.

See [Live Site1 preview](https://site1.romanenko-studio.dev).

## Docs

- [file structure](/docs/)
- [concept](/docs/concept.md)
- [routing list](/docs/routing_list.md)
- [menu](/docs/menu.md)
- [design](/docs/html_design.md)
- [google recaptcha](/docs/recaptcha.md)

## Install (Docker)

1. run `docker compose up`
2. open in a browser url - localhost:8000

### X-debug

- Copy xdebug.ini.back to xdebug.ini in *docker/php-fpm/php/conf.d*
- uncomment settings
- make change in your IDE

## Install (Manual)

1. use nginx [config](./nginx/simple.conf)
2. create a database with [sql](./sql/site1-empty-users.sql)

## Production

- Docker is not ready

## Other projects

You can see a more complex version of the website with more functionality on the [Site2 github](https://github.com/Romchik38/site2) page. It demonstrates multilanguage system, twig view, Image Converter and other features.

Look at [Live Site2 preview](https://site2.romanenko-studio.dev/en/about-this-site).

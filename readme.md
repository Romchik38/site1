# Readme

This is an example site to show how [php-server](https://github.com/Romchik38/server) works.

See [live preview](https://site1.romanenko-studio.dev) site.

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

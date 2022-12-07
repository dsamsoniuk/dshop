# DShop


### What i used

Symfony 6.2, 
PHP 8.1,
Docker,
RabbitMQ,
MySQL 8.0,
UnitTest 9.5
VueJS

Design patterns: Strategy, Builder
Good practics: SOLID, KISS, DRY, YAGNI
Tests: Unit test, functionaly test, integration test


### Required

php 8.1

### Install

```bash
composer install

docker compose up # will install mysql, rabbitMQ

php bin/console doctrine:migrations:migrate

```
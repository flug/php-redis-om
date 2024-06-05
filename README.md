# [WIP] BETA VERSION IN PROGRESS

# php-redis-om

A PHP object mapper for [Redis](https://redis.io/).

An Object Mapper for Redis, designed to providing an intuitive and familiar interface for PHP developers to interact
with Redis.

## Features

- Doctrine-like methods and architecture
- Easy integration with existing PHP applications
- High performance and scalability with Redis
- Support for Redis JSON module
- Automatic schema generation
- Search and query capabilities

## Requirements

- PHP 8.2 or higher
- Redis 4.0 or higher
- php-redis extension (or your favorite Redis client)
- Redis JSON module (optional)
- Composer

## Installation

Install the library via Composer:

```console
composer require talleu/php-redis-om
```

## Basic Usage

Add the RedisOm attribute to your class to map it to a Redis schema:

```php  
<?php 

use Talleu\RedisOm\Om\Mapping as RedisOm;

#[RedisOm\Entity]
class User
{
    #[RedisOm\Id]
    #[RedisOm\Property]
    public int $id;

    #[RedisOm\Property]
    public string $name;

    #[RedisOm\Property]
    public \DateTimeImmutable $createdAt;
}
```

After add the RedisOm attribute to your class,
you have to run the following command to create the Redis schema for the given source directory: 

```console
vendor/bin/redisMigration src
```

Then you can use the ObjectManager to persist your objects from Redis:

```php
<?php

use Talleu\RedisOm\Om\RedisObjectManager;

$user = new User()
$user->id = 1;
$user->name = 'John Doe';

// Persist the object in redis
$objectManager = new ObjectManager();
$objectManager->persist($user);
$objectManager->flush();
```

🥳 Congratulations, your PHP object is now registered in Redis !


You can now retrieve your user wherever you like using the ObjectManager:

```php
// Retrieve the object from redis 
$user = $objectManager->find(User::class, 1);
$user = $objectManager->getRepository(User::class)->find(1);
$user = $objectManager->getRepository(User::class)->findOneBy(['name' => 'John Doe']);

// Retrieve a collection of objects
$users = $objectManager->getRepository(User::class)->findAll();
$users = $objectManager->getRepository(User::class)->findBy(['name' => 'John Doe'], ['createdAt' => 'DESC'], 10);
```

### Docker

The package provide a Docker Compose configuration to run a Redis 
server with the required modules (RedisJSON and Redisearch) for testing purposes.

```console
docker compose up -d
```

### Running tests

```console
docker compose exec php vendor/bin/phpunit tests
```


## Advanced mapping configuration
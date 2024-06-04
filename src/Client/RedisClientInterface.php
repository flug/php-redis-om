<?php

declare(strict_types=1);

namespace Talleu\RedisOm\Client;

use Talleu\RedisOm\Om\RedisFormat;

interface RedisClientInterface
{
    public function hMSet(string $key, array $data): void;
    public function hGetAll(string $key): array;
    public function del(string $key): void;
    public function jsonGet(string $key): ?string;
    public function jsonSet(string $key, ?string $path = '$', ?string $value = '{}'): ?bool;
    public function jsonDel(string $key, ?string $path = '$'): ?bool;
    public function createIndex(string $prefixKey, ?string $format = 'HASH', ?array $properties = []): bool;
    public function dropIndex(string $prefixKey): bool;
    public function count(string $prefixKey, array $criterias = []): int;
    public function search(string $prefixKey, array $search, array $orderBy, ?string $format = RedisFormat::HASH->value, ?int $numberOfResults = null): array;
    public function scanKeys(string $prefixKey): array;
    public function flushAll(): void;
}

<?php

declare(strict_types=1);

namespace Talleu\RedisOm\Tests\Functionnal\DataConsistency;

use Talleu\RedisOm\Om\RedisObjectManager;
use Talleu\RedisOm\Tests\Fixtures\Hash\NullHash;
use Talleu\RedisOm\Tests\Fixtures\Json\NullJson;
use Talleu\RedisOm\Tests\RedisAbstractTestCase;

class NullConsistencyTest extends RedisAbstractTestCase
{
    private RedisObjectManager $objectManager;
    protected function setUp(): void
    {
        $this->objectManager = new RedisObjectManager(RedisAbstractTestCase::createClient());
        parent::setUp();
    }

    public function testNullHash(): void
    {
        self::emptyRedis();
        self::generateIndex();

        $nullObject = new NullHash();
        $nullObject->id = 1;


        $this->objectManager->persist($nullObject);
        $this->objectManager->flush();

        $repository = $this->objectManager->getRepository(NullHash::class);
        $retrieveNullObject = $repository->find(1);
        $this->assertNull($retrieveNullObject->unknown);
    }

    public function testNotNullHash(): void
    {
        self::emptyRedis();
        self::generateIndex();

        $nullObject = new NullHash();
        $nullObject->id = 1;
        $nullObject->unknown = 'test';


        $this->objectManager->persist($nullObject);
        $this->objectManager->flush();

        $repository = $this->objectManager->getRepository(NullHash::class);
        $retrieveNullObject = $repository->find(1);
        $this->assertEquals($retrieveNullObject->unknown, 'test');
    }

    public function testNullJson(): void
    {
        self::emptyRedis();
        self::generateIndex();

        $nullObject = new NullJson();
        $nullObject->id = 1;

        $this->objectManager->persist($nullObject);
        $this->objectManager->flush();
        $repository = $this->objectManager->getRepository(NullJson::class);
        $retrieveNullObject = $repository->find(1);
        $this->assertNull($retrieveNullObject->unknown);
    }

    public function testNotNullJson(): void
    {
        self::emptyRedis();
        self::generateIndex();

        $nullObject = new NullJson();
        $nullObject->id = 1;
        $nullObject->unknown = 'test';

        $this->objectManager->persist($nullObject);
        $this->objectManager->flush();

        $repository = $this->objectManager->getRepository(NullJson::class);
        $retrieveNullObject = $repository->find(1);
        $this->assertEquals($retrieveNullObject->unknown, 'test');
    }
}

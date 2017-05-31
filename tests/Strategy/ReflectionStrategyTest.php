<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test\Strategy;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Zelenin\Hydrator\Strategy\ReflectionStrategy;
use Zelenin\Hydrator\Test\Data\Entity;

final class ReflectionStrategyTest extends TestCase
{
    public function testExtractWithoutDynamicProperties()
    {
        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $strategy = new ReflectionStrategy();
        $data = $strategy->extract($entity);

        $this->assertCount(2, $data);
        $this->assertEquals($entity->getId(), $data['id']);
        $this->assertEquals($entity->getName(), $data['name']);
    }

    public function testExtractWithDynamicProperties()
    {
        $id = 5;
        $name = 'Title';
        $dynamicField = 'dynamicValue';

        $entity = new Entity($id, $name);
        $entity->dynamicField = $dynamicField;
        $this->assertEquals($entity->dynamicField, $dynamicField);

        $strategy = new ReflectionStrategy();
        $data = $strategy->extract($entity);
        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('dynamicField', $data);

        $strategy = new ReflectionStrategy(true);
        $data = $strategy->extract($entity);
        $this->assertCount(3, $data);
        $this->assertEquals($entity->dynamicField, $data['dynamicField']);

        $entity = new \stdClass();
        $entity->dynamicField = $dynamicField;
        $this->assertEquals($entity->dynamicField, $dynamicField);

        $strategy = new ReflectionStrategy();
        $data = $strategy->extract($entity);
        $this->assertCount(0, $data);
        $this->assertArrayNotHasKey('dynamicField', $data);

        $strategy = new ReflectionStrategy(true);
        $data = $strategy->extract($entity);
        $this->assertCount(1, $data);
        $this->assertEquals($entity->dynamicField, $data['dynamicField']);
    }

    public function testHydrateWithDynamicProperties()
    {
        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $strategy = new ReflectionStrategy(true);

        $data = [
            'id' => 10,
            'name' => 'New title',
            'dynamicProperty' => 'dynamicValue',
        ];

        $newEntity = $strategy->hydrate($entity, $data);

        $this->assertEquals($newEntity->getId(), $data['id']);
        $this->assertEquals($newEntity->getName(), $data['name']);
        $this->assertEquals($newEntity->dynamicProperty, $data['dynamicProperty']);
    }

    public function testHydrateWithoutDynamicProperties()
    {
        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $strategy = new ReflectionStrategy();

        $data = [
            'id' => 10,
            'name' => 'New title',
        ];

        $newEntity = $strategy->hydrate($entity, $data);

        $this->assertEquals($newEntity->getId(), $data['id']);
        $this->assertEquals($newEntity->getName(), $data['name']);
    }

    public function testHydrateWithoutDynamicPropertiesException()
    {
        $this->expectException(InvalidArgumentException::class);

        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $strategy = new ReflectionStrategy();

        $data = [
            'id' => 10,
            'name' => 'New title',
            'dynamicProperty' => 'dynamicValue',
        ];

        $strategy->hydrate($entity, $data);
    }
}

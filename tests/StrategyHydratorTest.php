<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Hydrator\NamingStrategy\RawNamingStrategy;
use Zelenin\Hydrator\Strategy\ReflectionStrategy;
use Zelenin\Hydrator\StrategyHydrator;
use Zelenin\Hydrator\Test\Data\Entity;

final class StrategyHydratorTest extends TestCase
{
    public function testExtract()
    {
        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $hydrator = new StrategyHydrator(new ReflectionStrategy(), new RawNamingStrategy());

        $data = $hydrator->extract($entity);

        $this->assertEquals($entity->getId(), $data['id']);
        $this->assertEquals($entity->getName(), $data['name']);
    }

    public function testHydrate()
    {
        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $hydrator = new StrategyHydrator(new ReflectionStrategy(), new RawNamingStrategy());

        $data = [
            'id' => 10,
            'name' => 'New title',
        ];

        $newEntity = $hydrator->hydrate($entity, $data);

        $this->assertEquals($newEntity->getId(), $data['id']);
        $this->assertEquals($newEntity->getName(), $data['name']);
    }
}

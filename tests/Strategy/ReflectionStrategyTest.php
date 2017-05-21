<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test\Strategy;

use PHPUnit\Framework\TestCase;
use Zelenin\Hydrator\Strategy\ReflectionStrategy;
use Zelenin\Hydrator\Test\Data\Entity;

final class ReflectionStrategyTest extends TestCase
{
    public function testExtract()
    {
        $id = 5;
        $name = 'Title';

        $entity = new Entity($id, $name);

        $this->assertEquals($entity->getId(), $id);
        $this->assertEquals($entity->getName(), $name);

        $strategy = new ReflectionStrategy();

        $data = $strategy->extract($entity);

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

        $strategy = new ReflectionStrategy();

        $data = [
            'id' => 10,
            'name' => 'New title',
        ];

        $newEntity = $strategy->hydrate($entity, $data);


        $this->assertEquals($newEntity->getId(), $data['id']);
        $this->assertEquals($newEntity->getName(), $data['name']);
    }
}

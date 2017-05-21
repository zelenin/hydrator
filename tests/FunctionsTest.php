<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test;

use PHPUnit\Framework\TestCase;
use TypeError;
use Zelenin\Hydrator\Test\Data\Entity;
use function Zelenin\Hydrator\createObjectWithoutConstructor;

final class FunctionsTest extends TestCase
{
    public function testCreateObjectWithoutConstructor()
    {
        $entity = createObjectWithoutConstructor(Entity::class);

        $this->expectException(TypeError::class);

        $this->assertNull($entity->getId());
    }
}

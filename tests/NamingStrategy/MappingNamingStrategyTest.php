<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test\NamingStrategy;

use PHPUnit\Framework\TestCase;
use Zelenin\Hydrator\NamingStrategy\MappingNamingStrategy;

final class MappingNamingStrategyTest extends TestCase
{
    public function testRawNamingStrategy()
    {
        $strategy = new MappingNamingStrategy([
            'id' => 'ID',
        ]);

        $this->assertEquals('ID', $strategy->extract('id'));
        $this->assertEquals('id', $strategy->hydrate('ID'));
    }
}

<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test\NamingStrategy;

use PHPUnit\Framework\TestCase;
use Zelenin\Hydrator\NamingStrategy\RawNamingStrategy;

final class RawNamingStrategyTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testRawNamingStrategy($a, $b)
    {
        $strategy = new RawNamingStrategy();

        $this->assertEquals($a, $strategy->extract($a));
        $this->assertEquals($b, $strategy->hydrate($b));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            ['id', 'id'],
            ['post_id', 'postId'],
        ];
    }
}

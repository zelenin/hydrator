<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Test\NamingStrategy;

use PHPUnit\Framework\TestCase;
use Zelenin\Hydrator\NamingStrategy\UnderscoreToLowerCamelCaseNamingStrategy;

final class UnderscoreToLowerCamelCaseNamingStrategyTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testUnderscoreToLowerCamelCaseNamingStrategy($a, $b)
    {
        $strategy = new UnderscoreToLowerCamelCaseNamingStrategy();

        $this->assertEquals($a, $strategy->extract($b));
        $this->assertEquals($b, $strategy->hydrate($a));
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

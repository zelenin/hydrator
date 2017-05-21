<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\NamingStrategy;

final class RawNamingStrategy implements NamingStrategy
{
    /**
     * @inheritdoc
     */
    public function extract(string $name): string
    {
        return $name;
    }

    /**
     * @inheritdoc
     */
    public function hydrate(string $name): string
    {
        return $name;
    }
}

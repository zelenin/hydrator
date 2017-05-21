<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\NamingStrategy;

interface NamingStrategy
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function extract(string $name): string;

    /**
     * @param string $name
     *
     * @return string
     */
    public function hydrate(string $name): string;
}

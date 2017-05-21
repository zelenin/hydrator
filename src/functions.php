<?php
declare(strict_types=1);

namespace Zelenin\Hydrator;

use ReflectionClass;

/**
 * @param string $className
 *
 * @return object
 */
function createObjectWithoutConstructor(string $className)
{
    $reflectionClass = new ReflectionClass($className);
    return $reflectionClass->newInstanceWithoutConstructor();
}

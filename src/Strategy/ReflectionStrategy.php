<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Strategy;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;

final class ReflectionStrategy implements Strategy
{
    /**
     * @var array
     */
    private $propertiesCache;

    public function __construct()
    {
        $this->propertiesCache = [];
    }

    /**
     * @inheritdoc
     */
    public function extract($object): array
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Must be an object.');
        }

        $result = [];
        foreach ($this->getProperties(get_class($object)) as $property) {
            $result[$property->getName()] = $property->getValue($object);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function hydrate($object, array $data)
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Must be an object.');
        }

        $properties = $this->getProperties(get_class($object));

        foreach ($data as $name => $value) {
            if (isset($properties[$name])) {
                $properties[$name]->setValue($object, $value);
            }
        }

        return $object;
    }

    /**
     * @param string $className
     *
     * @return ReflectionProperty[]
     */
    private function getProperties(string $className): array
    {
        if (!isset($this->propertiesCache[$className])) {
            $reflectionClass = new ReflectionClass($className);
            foreach ($reflectionClass->getProperties() as $property) {
                $property->setAccessible(true);
                $this->propertiesCache[$className][$property->getName()] = $property;
            }
        }

        return $this->propertiesCache[$className];
    }
}

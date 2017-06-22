<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\Strategy;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionObject;
use ReflectionProperty;

final class ReflectionStrategy implements Strategy
{
    /**
     * @var array
     */
    private $propertiesCache;

    /**
     * @var bool
     */
    private $dynamicProperties;

    /**
     * @param bool $dynamicProperties
     */
    public function __construct(bool $dynamicProperties = false)
    {
        $this->propertiesCache = [];
        $this->dynamicProperties = $dynamicProperties;
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
        foreach ($this->getProperties($object) as $property) {
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

        $properties = $this->getProperties($object);

        foreach ($data as $name => $value) {
            if (isset($properties[$name])) {
                $properties[$name]->setValue($object, $value);
            } else {
                if ($this->dynamicProperties) {
                    $object->{$name} = $value;
                } else {
                    throw new InvalidArgumentException(sprintf('No property "%s" in class "%s".', $name, get_class($object)));
                }
            }
        }

        return $object;
    }

    /**
     * @param object $object
     *
     * @return ReflectionProperty[]
     */
    private function getProperties($object): array
    {
        $cacheId = $this->dynamicProperties ? spl_object_hash($object) : get_class($object);
        if (!isset($this->propertiesCache[$cacheId])) {
            $this->propertiesCache[$cacheId] = [];
            $reflection = $this->dynamicProperties ? new ReflectionObject($object) : new ReflectionClass($cacheId);
            do {
                foreach ($reflection->getProperties() as $property) {
                    $property->setAccessible(true);
                    $this->propertiesCache[$cacheId][$property->getName()] = $property;
                }
            } while ($reflection = $reflection->getParentClass());
        }

        return $this->propertiesCache[$cacheId];
    }
}

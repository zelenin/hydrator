<?php
declare(strict_types=1);

namespace Zelenin\Hydrator\NamingStrategy;

final class MappingNamingStrategy implements NamingStrategy
{
    /**
     * @var string
     */
    private $extractMapping;

    /**
     * @var string
     */
    private $hydrateMapping;

    /**
     * @param array $mapping
     */
    public function __construct(array $mapping)
    {
        $this->extractMapping = $mapping;
        $this->hydrateMapping = array_flip($mapping);
    }


    /**
     * @inheritdoc
     */
    public function extract(string $name): string
    {
        return $this->extractMapping[$name] ?: $name;
    }

    /**
     * @inheritdoc
     */
    public function hydrate(string $name): string
    {
        return $this->hydrateMapping[$name] ?: $name;
    }
}

<?php
declare(strict_types=1);

namespace Zelenin\Hydrator;

use Zelenin\Hydrator\NamingStrategy\NamingStrategy;
use Zelenin\Hydrator\Strategy\Strategy;

final class StrategyHydrator implements Hydrator
{
    /**
     * @var Strategy
     */
    private $strategy;

    /**
     * @var NamingStrategy
     */
    private $namingStrategy;

    /**
     * @param Strategy $strategy
     * @param NamingStrategy $namingStrategy
     */
    public function __construct(Strategy $strategy, NamingStrategy $namingStrategy)
    {
        $this->strategy = $strategy;
        $this->namingStrategy = $namingStrategy;
    }

    /**
     * @inheritdoc
     */
    public function extract($object): array
    {
        $data = $this->strategy->extract($object);

        $newNames = array_map(function (string $name): string {
            return $this->namingStrategy->extract($name);
        }, array_keys($data));

        return array_combine($newNames, $data);
    }

    /**
     * @inheritdoc
     */
    public function hydrate($object, array $data)
    {
        $newNames = array_map(function (string $name): string {
            return $this->namingStrategy->hydrate($name);
        }, array_keys($data));

        $data = array_combine($newNames, $data);

        return $this->strategy->hydrate($object, $data);
    }
}

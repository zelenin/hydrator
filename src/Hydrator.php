<?php
declare(strict_types=1);

namespace Zelenin\Hydrator;

interface Hydrator
{
    /**
     * @param object $object
     *
     * @return array
     */
    public function extract($object): array;

    /**
     * @param object $object
     * @param array $data
     *
     * @return object
     */
    public function hydrate($object, array $data);
}

<?php

declare(strict_types=1);

/*
 * This file is part of the project Elsie ERP.
 *
 * Copyright (C) Elsie - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 *
 */

namespace App\ObjectMapper\Transformer;

use ApiPlatform\Metadata\Exception\ItemNotFoundException;
use App\ObjectMapper\Custom\ClassTransformInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @implements ClassTransformInterface<object, object>
 */
final readonly class DoctrineClassTransformer implements ClassTransformInterface
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {
    }

    public function __invoke($source, $target): object
    {
        $toClass = $target::class;

        if (!property_exists($source, 'id')) {
            return $target;
        }

        // TODO Improve, assert it's an ApiRessource, find id by #[ApiProperty(identifier: true)] or api metadata
        $id = $source->id;

        if (null === $id) {
            return $target;
        }

        $manager = $this->managerRegistry->getManagerForClass($toClass);

        if (null === $manager) {
            throw new \RuntimeException(\sprintf('No manager found for class %s', $toClass));
        }

        $repository = $manager->getRepository($toClass);

        $entity = $repository->find($id);

        if (null === $entity) {
            throw new ItemNotFoundException(\sprintf('Entity %s with id %s not found', $toClass, $id));
        }

        return $entity;
    }
}

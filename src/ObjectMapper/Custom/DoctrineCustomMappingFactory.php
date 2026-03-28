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

namespace App\ObjectMapper\Custom;

use App\ObjectMapper\Transformer\DoctrineClassTransformer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(CustomMappingFactoryInterface::class)]
class DoctrineCustomMappingFactory implements CustomMappingFactoryInterface
{
    public function __construct(
        #[AutowireDecorated]
        private CustomMappingFactoryInterface $inner,
        private ManagerRegistry $managerRegistry,
    ) {
    }

    public function create(string $sourceClass, string $targetClass): Mapping
    {
        $mapping = $this->inner->create($sourceClass, $targetClass);

        $manager = $this->managerRegistry->getManagerForClass($targetClass);

        if (null !== $manager) {
            $mapping = new Mapping(
                $mapping->source,
                $mapping->target,
                null === $mapping->transform ? [DoctrineClassTransformer::class] : [DoctrineClassTransformer::class, ...$mapping->transform],
                $mapping->properties,
            );
        }

        return $mapping;
    }
}

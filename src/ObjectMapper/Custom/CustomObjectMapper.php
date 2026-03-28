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

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\ObjectMapper\Exception\MappingException;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Webmozart\Assert\Assert;

/**
 * Service to map source objects to target objects.
 */
#[AsAlias(ObjectMapperInterface::class)]
#[AsAlias('object_mapper')]
final class CustomObjectMapper implements ObjectMapperInterface
{
    /**
     * @param ClassFactoryInterface<object> $classFactory
     */
    public function __construct(
        private readonly CustomMappingFactoryInterface $mappingFactory,
        private readonly PropertyAccessorInterface $propertyAccessor,
        #[AutowireLocator('app.object_mapper.class_transform')]
        private readonly ?ContainerInterface $classTransformContainer,
        #[AutowireLocator('app.object_mapper.value_transform')]
        private readonly ?ContainerInterface $valueTransformContainer,
        private readonly ClassFactoryInterface $classFactory,
    ) {
    }

    /**
     * Maps a source object to a target object.
     *
     * @template T of object
     *
     * @param object                 $source the source object to map
     * @param T|class-string<T>|null $target the target object or the target class name
     *
     * @return T the mapped object
     */
    public function map(object $source, object|string|null $target = null): object
    {
        Assert::notNull($target, 'CustomObjectMapper not compatible with null target');

        $targetClass = \is_object($target) ? $target::class : $target;
        $mapping = $this->mappingFactory->create($source::class, $targetClass);

        $mappedTarget = \is_object($target) ? $target : $this->classFactory->__invoke($targetClass);

        if ($source::class === $mappedTarget::class) {
            throw new MappingException(\sprintf('Source class %s equal to target class %s', $source::class, $target::class));
        }

        // Global transformation BEFORE property mapping
        if ($mapping->transform) {
            foreach ($mapping->transform as $transform) {
                $resolvedTransform = $this->resolveTransform($transform, $this->classTransformContainer);
                if ($resolvedTransform) {
                    // utile de pouvoir remplacer le mappedTarget
                    $mappedTarget = $resolvedTransform($source, $mappedTarget);
                }
            }
        }

        if (!$mappedTarget instanceof $targetClass) {
            throw new MappingException(\sprintf('Global transformation must return an object, got "%s".', get_debug_type($mappedTarget)));
        }

        foreach ($mapping->properties as $propertyMapping) {
            $sourceProp = $propertyMapping->source;
            $targetProp = $propertyMapping->getTarget();

            if (!$this->propertyAccessor->isReadable($source, $sourceProp)) { // A passer dans le CustomMappingBuilder ?
                continue;
            }

            $value = $this->propertyAccessor->getValue($source, $sourceProp);

            // Property transformation
            if ($propertyMapping->transform) {
                foreach ($propertyMapping->transform as $transform) {
                    $resolvedTransform = $this->resolveTransform($transform, $this->valueTransformContainer);
                    if ($resolvedTransform) {
                        $value = $resolvedTransform($value);
                    }
                }
            }

            // Recursivity if value is an object
            if (\is_object($value)) {
                try {
                    $targetPropRefl = new \ReflectionProperty($targetClass, $targetProp); // Stocker au map building ? -> PropertyMapping
                    $targetPropType = $targetPropRefl->getType();

                    if ($targetPropType instanceof \ReflectionNamedType && !$targetPropType->isBuiltin()) {
                        $targetTypeName = $targetPropType->getName();
                        if (!$value instanceof $targetTypeName) {
                            // TODO Better target type resolve
                            // @phpstan-ignore-next-line argument.templateType
                            $value = $this->map($value, $targetTypeName);
                        }
                    }
                } catch (\ReflectionException $e) {
                    throw $e;
                    // If target type cannot be determined, leave the value as is (or could log)
                }
            }

            $this->propertyAccessor->setValue($mappedTarget, $targetProp, $value);
        }

        return $mappedTarget;
    }

    /**
     * Resolves a transformation that can be a callable or a container service.
     */
    private function resolveTransform(mixed $transform, ?ContainerInterface $container): ?callable
    {
        if (\is_callable($transform)) {
            return $transform;
        }

        if (\is_string($transform) && $container && $container->has($transform)) {
            $service = $container->get($transform);
            if (\is_callable($service)) {
                return $service;
            }
        }

        return null;
    }
}

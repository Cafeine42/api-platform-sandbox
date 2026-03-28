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

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\ObjectMapper\Exception\MappingException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Service to initialize and keep in cache a Mapping with its PropertyMappings.
 */
#[AsAlias(CustomMappingFactoryInterface::class)]
class CustomMappingFactory implements CustomMappingFactoryInterface
{
    public function __construct(
        private readonly PropertyAccessorInterface $propertyAccessor,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
    }

    /**
     * Crée ou récupère depuis le cache un Mapping entre une source et une cible.
     * Les transformations globales ne peuvent plus être passées en paramètre et
     * sont récupérées depuis les attributs #[Map] au niveau de la classe source,
     * uniquement si leur "target" correspond à $targetClass.
     *
     * @param class-string $sourceClass
     * @param class-string $targetClass
     */
    public function create(string $sourceClass, string $targetClass): Mapping
    {
        try {
            $sourceRefl = new \ReflectionClass($sourceClass);
            $targetRefl = new \ReflectionClass($targetClass);
        } catch (\ReflectionException $e) { // @phpstan-ignore catch.neverThrown
            throw new MappingException($e->getMessage(), $e->getCode(), $e);
        }

        $propertyMappings = $this->discoverPropertyMappings($sourceRefl, $targetRefl);

        // Découverte des transformations globales via les attributs #[Map] de la classe source
        $classTransforms = null;
        $classAttributes = $sourceRefl->getAttributes(Map::class, \ReflectionAttribute::IS_INSTANCEOF);
        $matched = false;
        foreach ($classAttributes as $attr) {
            /** @var Map $mapAttr */
            $mapAttr = $attr->newInstance();
            // On ne retient que les attributs dont la target correspond exactement à la classe cible
            if (null !== $mapAttr->target && $mapAttr->target === $targetClass) {
                if ($matched) {
                    throw new MappingException(\sprintf('Multiple matching target detected on %s', $sourceClass));
                }
                if (null !== $mapAttr->transform) {
                    $classTransforms = \is_array($mapAttr->transform) ? $mapAttr->transform : [$mapAttr->transform];
                }
                $matched = true;
            }
        }

        if (false === $matched) {
            throw new MappingException(\sprintf('No matching detected between source %s and target %s', $sourceClass, $targetClass));
        }

        /* @phpstan-ignore-next-line argument.type */
        return new Mapping($sourceClass, $targetClass, $classTransforms, $propertyMappings);
    }

    /**
     * @param \ReflectionClass<object> $sourceRefl
     * @param \ReflectionClass<object> $targetRefl
     *
     * @return array<string, PropertyMapping>
     */
    private function discoverPropertyMappings(\ReflectionClass $sourceRefl, \ReflectionClass $targetRefl): array
    {
        $propertyMappings = [];

        foreach ($sourceRefl->getProperties() as $sourceProperty) {
            if ($sourceProperty->isStatic()) {
                continue;
            }

            $propertyName = $sourceProperty->getName();
            $attributes = $sourceProperty->getAttributes(Map::class, \ReflectionAttribute::IS_INSTANCEOF);

            $mapAttr = null;
            if ($attributes) {
                $mapAttr = $attributes[0]->newInstance();

                if (false === $mapAttr->if) {
                    continue;
                }
            }

            $targetPropertyName = $mapAttr && $mapAttr->target ? $mapAttr->target : $propertyName;

            // On vérifie si la propriété cible est accessible en écriture via PropertyAccessor
            // Pour cela on a besoin d'une instance ou on peut utiliser isWritable avec un objet temporaire ou juste faire confiance au mapping
            // Mais le but ici est de "découvrir" ce qui est possible.
            // La Reflection reste utile pour lister les propriétés, mais PropertyAccessor décidera si on peut les utiliser.

            // On vérifie si la propriété existe sur la cible d'une manière ou d'une autre (propriété réelle ou setter)
            if (!$this->propertyAccessor->isWritable($targetInstance = new ($targetRefl->getName()), $targetPropertyName)) {
                $this->logger->debug(\sprintf('Property "%s" is not writable on target "%s", skipping.', $targetPropertyName, $targetRefl->getName()));
                continue;
            }

            $propertyMappings[$propertyName] = new PropertyMapping(
                $propertyName,
                $targetPropertyName === $propertyName ? null : $targetPropertyName,
                /* @phpstan-ignore-next-line argument.type zut */
                null !== $mapAttr ? \is_array($mapAttr->transform) ? $mapAttr->transform : [$mapAttr->transform] : null
            );
        }

        return $propertyMappings;
    }
}

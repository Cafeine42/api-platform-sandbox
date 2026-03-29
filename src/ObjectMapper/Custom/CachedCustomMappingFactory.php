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

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Contracts\Cache\CacheInterface;

#[AsDecorator(CustomMappingFactoryInterface::class, priority: 1024)]
class CachedCustomMappingFactory implements CustomMappingFactoryInterface
{
    public function __construct(
        #[AutowireDecorated]
        private CustomMappingFactoryInterface $inner,
        #[Autowire(service: 'cache.system')]
        private CacheInterface $cache,
    ) {
    }

    public function create(string $sourceClass, string $targetClass): Mapping
    {
        return $this->cache->get('object_mapper_mapping_'.self::hash($sourceClass.':'.$targetClass), fn (): Mapping => $this->inner->create($sourceClass, $targetClass));
    }

    private static function hash(string $toHash): string
    {
        return str_replace('/', '_', base64_encode(hash('sha256', $toHash, true)));
    }
}

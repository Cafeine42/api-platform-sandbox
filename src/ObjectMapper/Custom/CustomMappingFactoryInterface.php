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

/**
 * Service to initialize and keep in cache a Mapping with its PropertyMappings.
 */
interface CustomMappingFactoryInterface
{
    /**
     * @param class-string $sourceClass
     * @param class-string $targetClass
     */
    public function create(string $sourceClass, string $targetClass): Mapping;
}

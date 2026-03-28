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

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @template T as object
 * @template T2 as object
 * Interface to transform a class into another (global transformation).
 */
#[AutoconfigureTag('app.object_mapper.class_transform')]
interface ClassTransformInterface
{
    /**
     * @param T  $source the source object
     * @param T2 $target the target object
     *
     * @return T2 the transformed or re-instantiated target object
     */
    public function __invoke($source, $target);
}

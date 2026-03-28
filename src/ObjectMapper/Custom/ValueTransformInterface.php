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
 * Interface to transform a property value.
 *
 * @template T as mixed
 * @template T2 as mixed
 */
#[AutoconfigureTag('app.object_mapper.value_transform')]
interface ValueTransformInterface
{
    /**
     * @param T $value the value to transform
     *
     * @return T2 the transformed value
     */
    public function __invoke($value);
}

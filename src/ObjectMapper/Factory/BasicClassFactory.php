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

namespace App\ObjectMapper\Factory;

use App\ObjectMapper\Custom\ClassFactoryInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @implements ClassFactoryInterface<object>
 */
#[AsAlias(ClassFactoryInterface::class)]
class BasicClassFactory implements ClassFactoryInterface
{
    public function __invoke($target)
    {
        return new $target();
    }
}

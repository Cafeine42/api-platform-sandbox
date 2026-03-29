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

namespace App\ObjectMapper\Transformer\User;

use App\Api\Dto\User\PartialUpdateUserInput;
use App\Entity\User;
use App\ObjectMapper\Custom\ClassTransformInterface;

/**
 * @implements ClassTransformInterface<PartialUpdateUserInput, User>
 */
final readonly class PartialUpdateUserInputTransformer implements ClassTransformInterface
{
    public function __invoke($source, $target): User
    {
        if (isset($source->resetOTP)) {
            $target->setResetOTP($source->resetOTP);
        }

        return $target;
    }
}

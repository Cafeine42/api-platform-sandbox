<?php

namespace App\Tests;

use App\Factory\GreetingFactory;

class Story extends \Zenstruck\Foundry\Story
{
    public function build(): void
    {
        GreetingFactory::createMany(5);
    }
}

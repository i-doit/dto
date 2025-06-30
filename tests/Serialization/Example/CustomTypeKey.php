<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

use Idoit\Dto\Serialization\Discriminator;

#[Discriminator([
    'a' => CustomClassA::class,
    'b' => CustomClassB::class,
], 'test')]
abstract class CustomTypeKey
{

}

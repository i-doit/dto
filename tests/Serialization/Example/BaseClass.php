<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

use JsonSerializable;
use Idoit\Dto\Serialization\Discriminator;
use Idoit\Dto\Serialization\SerializableTrait;

#[Discriminator([
    'a' => ClassA::class,
    'b' => ClassB::class,
])]
abstract class BaseClass implements JsonSerializable
{
    use SerializableTrait;

    public function __construct(protected string $name)
    {
    }
}

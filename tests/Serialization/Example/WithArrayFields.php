<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

use JsonSerializable;
use Idoit\Dto\Serialization\ArrayFormat;
use Idoit\Dto\Serialization\SerializableTrait;

class WithArrayFields implements JsonSerializable
{
    use SerializableTrait;

    public function __construct(
        #[ArrayFormat(Primitives::class)]
        private array $primitiveArray,
        #[ArrayFormat(BaseClass::class)]
        private array $objects,
    )
    {
    }
}

<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\OneOf;

class NumberValuesSet
{
    public function __construct(
        #[OneOf([1, 2, 3, 4, 5])]
        public readonly int $value
    )
    {
    }
}

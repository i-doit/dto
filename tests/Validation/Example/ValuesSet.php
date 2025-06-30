<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\OneOf;

class ValuesSet
{
    public function __construct(
        #[OneOf(['a', 'b', 'c'])]
        public readonly string $value
    )
    {
    }
}

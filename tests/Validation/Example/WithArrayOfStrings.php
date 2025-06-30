<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\IsArrayOf;
use Idoit\Dto\Validation\IsString;

class WithArrayOfStrings
{
    public function __construct(
        #[IsArrayOf(new IsString())]
        public readonly array $value
    )
    {
    }
}

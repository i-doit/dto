<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\IsArrayOf;
use Idoit\Dto\Validation\IsInstanceOf;

class WithArrayOfInstance
{
    public function __construct(
        #[IsArrayOf(new IsInstanceOf(WithRequired::class))]
        private readonly array $value
    )
    {
    }
}

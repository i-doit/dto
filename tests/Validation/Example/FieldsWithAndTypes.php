<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\AndX;
use Idoit\Dto\Validation\IsInt;
use Idoit\Dto\Validation\PositiveInteger;

class FieldsWithAndTypes
{
    public function __construct(
        #[AndX(new IsInt(), new PositiveInteger())]
        public readonly mixed $value,
        #[IsInt]
        #[PositiveInteger]
        public readonly mixed $alternative,
    )
    {
    }
}

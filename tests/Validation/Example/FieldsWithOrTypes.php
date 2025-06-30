<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\IsInt;
use Idoit\Dto\Validation\IsString;
use Idoit\Dto\Validation\OrX;

class FieldsWithOrTypes
{
    public function __construct(
        #[OrX(new IsInt(), new IsString())]
        public readonly mixed $value
    )
    {
    }
}

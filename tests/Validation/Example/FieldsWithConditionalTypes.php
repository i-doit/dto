<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\AndX;
use Idoit\Dto\Validation\IsInt;
use Idoit\Dto\Validation\IsNull;
use Idoit\Dto\Validation\OrX;
use Idoit\Dto\Validation\PositiveInteger;

class FieldsWithConditionalTypes
{
    public function __construct(
        #[OrX(new IsNull(), new AndX(new IsInt(), new PositiveInteger()))]
        public readonly mixed $value,
    )
    {
    }
}

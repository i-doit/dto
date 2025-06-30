<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

class WithNestedFields
{
    public function __construct(
        public readonly NumberValuesSet $one,
        public readonly WithRequired $required,
        public readonly WithValidationCallback $test,
    )
    {
    }
}

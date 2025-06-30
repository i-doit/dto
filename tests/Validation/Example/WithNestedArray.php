<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

class WithNestedArray
{
    public function __construct(public array $values)
    {
    }
}

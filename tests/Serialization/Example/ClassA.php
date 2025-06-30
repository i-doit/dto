<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

class ClassA extends BaseClass
{
    public function __construct(string $name, private string $extraField)
    {
        parent::__construct($name);
    }
}

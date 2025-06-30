<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

class ClassB extends BaseClass
{
    public function __construct(string $name, private int $number)
    {
        parent::__construct($name);
    }
}

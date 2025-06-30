<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

class CustomClassA extends CustomTypeKey
{
    public function __construct(private string $name)
    {
    }
}

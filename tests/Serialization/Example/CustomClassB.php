<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

class CustomClassB extends CustomTypeKey
{
    public function __construct(private string $value)
    {
    }
}

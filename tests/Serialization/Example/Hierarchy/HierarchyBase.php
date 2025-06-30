<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example\Hierarchy;

use Idoit\Dto\Serialization\Discriminator;

#[Discriminator([
    'child' => HierarchyChild::class,
    'another' => HierarchyAnother::class,
])]
abstract class HierarchyBase
{

}

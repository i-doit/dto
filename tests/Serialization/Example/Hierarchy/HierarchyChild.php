<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example\Hierarchy;

use Idoit\Dto\Serialization\Discriminator;

#[Discriminator([
    'a' => HierarchyChildA::class,
    'b' => HierarchyChildB::class,
], 'subtype')]
abstract class HierarchyChild extends HierarchyBase
{

}

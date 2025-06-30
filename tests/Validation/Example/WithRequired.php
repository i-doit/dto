<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\Required;

class WithRequired
{
    public function __construct(
        #[Required]
        public readonly string $field
    )
    {
    }
}

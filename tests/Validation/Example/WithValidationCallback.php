<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation\Example;

use Idoit\Dto\Validation\ValidationCallback;
use Idoit\Dto\Validation\ValidationMessage;

class WithValidationCallback
{
    public function __construct(private int $a, private int $b)
    {
    }

    #[ValidationCallback]
    public function checkConsistency(array $path): array
    {
        $results = [];

        if ($this->a < $this->b) {
            $results[] = new ValidationMessage([...$path, 'a'], 'Field a should be greater than b');
            $results[] = new ValidationMessage([...$path, 'b'], 'Field b should be less than a');
        }

        return $results;
    }
}

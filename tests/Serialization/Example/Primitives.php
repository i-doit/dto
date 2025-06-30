<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization\Example;

use DateTime;
use JsonSerializable;
use Idoit\Dto\Serialization\DateFormat;
use Idoit\Dto\Serialization\SerializableTrait;

class Primitives implements JsonSerializable
{
    use SerializableTrait;

    public function __construct(
        public int $number,
        public string $string,
        public array $array,
        #[DateFormat]
        public DateTime $datetime,
    )
    {
    }
}

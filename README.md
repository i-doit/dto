# i-doit DTO

This library provides methods to simplify working with DTOs in PHP.

It provides serialization and validation helpers to define behaviour of the DTO via attributes.

## Setup

Require library via composer

```
composer require idoit/dto
```

## Usage

For the following examples we will use this DTO class that defines some public readonly properpties.
Please note the attributes which will be used for validation and, in case of `DateFormat`, serialization:

```php
use Idoit\Dto\Validation\IsNull;
use Idoit\Dto\Validation\OrX;
use Idoit\Dto\Validation\PositiveInteger;
use Idoit\Dto\Validation\Required;
use Idoit\Dto\Serialization\DateFormat;

/**
 * Object read DTO. Will be returned when reading objects via processor.
 */
class MyDto
{
    public function __construct(
        #[Required]
        #[PositiveInteger]
        public readonly int $id = 0,
        
        public readonly string|null $title = null,
        
        #[OrX(new IsNull(), new PositiveInteger())]
        public readonly int|null $type = null,
        
        #[DateFormat]
        public readonly DateTime|null $created = null
        // ...
    ) {
    }
}
```

### Validation

In order to validate this DTO, you can use `Validation::validate($dto);`, like so:

```php
use Idoit\Dto\Validation\Validation;

$dto = new MyDto(5, 'My Title', -1); // Has a negative type, but SHOULD be null or positive.

$errors = Validation::validate($dto);
/*
 * '$errors' will contain the following data:
 * 
 * array (
 *   0 => \Idoit\Dto\Validation\ValidationMessage::__set_state(array(
 *     'path' =>
 *       array (
 *         0 => 'type'
 *       ),
 *     'message' => 'The value must be a null.'
 *   )),
 *   1 => \Idoit\Dto\Validation\ValidationMessage::__set_state(array(
 *     'path' =>
 *       array (
 *         0 => 'type'
 *       ),
 *     'message' => 'The value must be positive number.'
 *   ))
 * )
 */
```

If you need specific logic for validation you can simply create your own classes to do so.
Simply implement the `\Idoit\Dto\Validation\ValidatorInterface` interface and write your own `validate` method.

### Serialization

We can use `Serializer` to convert JSON structures to DTOs and the other way around:

```php
$dto = \Idoit\Dto\Serialization\Serializer::fromJson(MyDto::class, [
    'id' => 123, 
    'title' => 'Silvester', 
    'type' => 2,
    'created' => '2025-12-31T00:00:00+00:00'
]);
/*
 * '$dto' will contain the following data:
 * 
 * \MyDto::__set_state(array(
 *    'id' => 123,
 *    'title' => 'Silvester',
 *    'type' => 2,
 *    'created' => 
 *   \DateTime::__set_state(array(
 *      'date' => '2025-12-31 00:00:00.000000',
 *      'timezone_type' => 1,
 *      'timezone' => '+00:00'
 *   ))
 * ))
 */

$array = \Idoit\Dto\Serialization\Serializer::toJSON($dto);
/**
 * '$array' will contain the following data: 
 * 
 * array (
 *   'id' => 123,
 *   'title' => 'Silvester',
 *   'type' => 2,
 *   'created' => '2025-12-31T00:00:00+00:00'
 * )
 */
```

If you need specific logic for serialization you can simply create your own classes to do so.
Simply extend the abstract `Idoit\Dto\Serialization\Format` class and implement your own `toJson` and `fromJson` methods. 

**Please note** that the validation will not be executed, when serializing data.

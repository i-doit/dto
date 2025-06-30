<?php declare(strict_types = 1);

namespace Idoit\Dto\Validation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Idoit\Dto\Validation\Example\FieldsWithAndTypes;
use Idoit\Dto\Validation\Example\FieldsWithConditionalTypes;
use Idoit\Dto\Validation\Example\FieldsWithOrTypes;
use Idoit\Dto\Validation\Example\NumberValuesSet;
use Idoit\Dto\Validation\Example\ValuesSet;
use Idoit\Dto\Validation\Example\WithArrayOfInstance;
use Idoit\Dto\Validation\Example\WithArrayOfStrings;
use Idoit\Dto\Validation\Example\WithNestedArray;
use Idoit\Dto\Validation\Example\WithNestedFields;
use Idoit\Dto\Validation\Example\WithRequired;
use Idoit\Dto\Validation\Example\WithValidationCallback;

class ValidationTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'required' => [
                new WithRequired(''),
                [new ValidationMessage(['field'], 'The value is required.')]
            ],
            'required with value' => [
                new WithRequired('test'),
                []
            ],
            'not from enum' => [
                new ValuesSet('test'),
                [new ValidationMessage(['value'], 'Value should be one of: a, b, c.')]
            ],
            'from enum' => [
                new ValuesSet('a'),
                []
            ],
            'not from int enum' => [
                new NumberValuesSet(23),
                [new ValidationMessage(['value'], 'Value should be one of: 1, 2, 3, 4, 5.')]
            ],
            'from int enum' => [
                new NumberValuesSet(3),
                []
            ],
            'with custom validation' => [
                new WithValidationCallback(1, 3),
                [new ValidationMessage(['a'], 'Field a should be greater than b'), new ValidationMessage(['b'], 'Field b should be less than a')]
            ],
            'with custom validation passed' => [
                new WithValidationCallback(10, 3),
                []
            ],
            'nested with all errors' => [
                new WithNestedFields(new NumberValuesSet(12), new WithRequired(''), new WithValidationCallback(1, 2)),
                [
                    new ValidationMessage(['one', 'value'], 'Value should be one of: 1, 2, 3, 4, 5.'),
                    new ValidationMessage(['required', 'field'], 'The value is required.'),
                    new ValidationMessage(['test', 'a'], 'Field a should be greater than b'),
                    new ValidationMessage(['test', 'b'], 'Field b should be less than a'),
                ]
            ],
            'nested with one error' => [
                new WithNestedFields(new NumberValuesSet(12), new WithRequired('test'), new WithValidationCallback(10, 2)),
                [
                    new ValidationMessage(['one', 'value'], 'Value should be one of: 1, 2, 3, 4, 5.'),
                ]
            ],
            'nested with other error' => [
                new WithNestedFields(new NumberValuesSet(1), new WithRequired(''), new WithValidationCallback(10, 2)),
                [
                    new ValidationMessage(['required', 'field'], 'The value is required.'),
                ]
            ],
            'nested array' => [
                new WithNestedArray([new WithRequired(''), new WithRequired('')]),
                [
                    new ValidationMessage(['values', '0', 'field'], 'The value is required.'),
                    new ValidationMessage(['values', '1', 'field'], 'The value is required.'),
                ]
            ],
            'nested array with last error' => [
                new WithNestedArray([new WithRequired('123'), new WithRequired('')]),
                [
                    new ValidationMessage(['values', '1', 'field'], 'The value is required.'),
                ]
            ],
            'nested array with nested error' => [
                new WithNestedArray([
                    new WithNestedFields(new NumberValuesSet(12), new WithRequired('test'), new WithValidationCallback(10, 2))
                ]),
                [
                    new ValidationMessage(['values', '0', 'one', 'value'], 'Value should be one of: 1, 2, 3, 4, 5.'),
                ]
            ],
            'orx with supported string value' => [
                new FieldsWithOrTypes('string'),
                []
            ],
            'orx with supported int value' => [
                new FieldsWithOrTypes(12),
                []
            ],
            'orx with non supported value' => [
                new FieldsWithOrTypes([12]),
                [
                    new ValidationMessage(['value'], 'The value must be an integer.'),
                    new ValidationMessage(['value'], 'The value must be a string.'),
                ]
            ],
            'andx with supported value' => [
                new FieldsWithAndTypes(23, 23),
                []
            ],
            'andx with non supported int value' => [
                new FieldsWithAndTypes(-12, -12),
                [
                    new ValidationMessage(['value'], 'The value must be positive number.'),
                    new ValidationMessage(['alternative'], 'The value must be positive number.'),
                ]
            ],
            'andx with non supported value' => [
                new FieldsWithAndTypes('test', 'test'),
                [
                    new ValidationMessage(['value'], 'The value must be an integer.'),
                    new ValidationMessage(['alternative'], 'The value must be an integer.'),
                ]
            ],
            'conditional types' => [
                new FieldsWithConditionalTypes('test'),
                [
                    new ValidationMessage(['value'], 'The value must be a null.'),
                    new ValidationMessage(['value'], 'The value must be an integer.'),
                ]
            ],
            'with array of required' => [
                new WithArrayOfInstance([new WithRequired('1'), new WithRequired('2')]),
                [
                ]
            ],
            'with array of required with errors' => [
                new WithArrayOfInstance(['1', new WithRequired('')]),
                [
                    new ValidationMessage(['value', '0'], 'The value must be an instance of Idoit\Dto\Validation\Example\WithRequired.'),
                    new ValidationMessage(['value', '1', 'field'], 'The value is required.'),
                ]
            ],
            'with array of required non matching' => [
                new WithArrayOfInstance(['test', new WithRequired('2')]),
                [
                    new ValidationMessage(['value', '0'], 'The value must be an instance of Idoit\Dto\Validation\Example\WithRequired.'),
                ]
            ],
            'with array of required second non matching' => [
                new WithArrayOfInstance([new WithRequired('2'), 'test']),
                [
                    new ValidationMessage(['value', '1'], 'The value must be an instance of Idoit\Dto\Validation\Example\WithRequired.'),
                ]
            ],
            'with array of strings' => [
                new WithArrayOfStrings(['a', 'b']),
                [
                ]
            ],
            'with array of non strings' => [
                new WithArrayOfStrings([1, new WithRequired('2')]),
                [
                    new ValidationMessage(['value', '0'], 'The value must be a string.'),
                    new ValidationMessage(['value', '1'], 'The value must be a string.'),
                ]
            ],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testValidation(object $object, array $expected): void
    {
        $messages = Validation::validate($object);
        $this->assertEquals($expected, $messages);
    }
}

<?php declare(strict_types = 1);

namespace Idoit\Dto\Serialization;

use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Idoit\Dto\Serialization\Example\ClassA;
use Idoit\Dto\Serialization\Example\ClassB;
use Idoit\Dto\Serialization\Example\CustomClassA;
use Idoit\Dto\Serialization\Example\CustomClassB;
use Idoit\Dto\Serialization\Example\Hierarchy\HierarchyAnother;
use Idoit\Dto\Serialization\Example\Hierarchy\HierarchyChildA;
use Idoit\Dto\Serialization\Example\Hierarchy\HierarchyChildB;
use Idoit\Dto\Serialization\Example\Primitives;
use Idoit\Dto\Serialization\Example\WithArrayFields;

class SerializationTest extends TestCase
{
    public static function dataProvider(): array
    {
        $primitive = new Primitives(12, 'test', ['a', 'b'], DateTime::createFromFormat(DateTimeInterface::ATOM, '2025-02-02T12:23:00+00:00'));
        return [
            'primitives' => [
                $primitive,
                [
                    'number' => 12,
                    'string' => 'test',
                    'array' => ['a', 'b'],
                    'datetime' => '2025-02-02T12:23:00+00:00',
                ],
            ],
            'discriminator A' => [
                new ClassA('name1', 'extra'),
                ['type' => 'a', 'extraField' => 'extra', 'name' => 'name1'],
            ],
            'discriminator B' => [
                new ClassB('name2', 12),
                ['type' => 'b', 'number' => 12, 'name' => 'name2']
            ],
            'custom discriminator A' => [
                new CustomClassA('test'),
                ['test' => 'a', 'name' => 'test']
            ],
            'custom discriminator B' => [
                new CustomClassB('test'),
                ['test' => 'b', 'value' => 'test']
            ],
            'hierarchy child A' => [
                new HierarchyChildA(),
                ['type' => 'child', 'subtype' => 'a']
            ],
            'hierarchy child B' => [
                new HierarchyChildB(),
                ['type' => 'child', 'subtype' => 'b']
            ],
            'hierarchy another' => [
                new HierarchyAnother(),
                ['type' => 'another']
            ],
            'array fields' => [
                new WithArrayFields([$primitive, $primitive], [new ClassA('name1', 'extra'), new ClassB('name2', 12)]),
                [
                    'primitiveArray' => [
                        [
                            'number' => 12,
                            'string' => 'test',
                            'array' => ['a', 'b'],
                            'datetime' => '2025-02-02T12:23:00+00:00',
                        ],
                        [
                            'number' => 12,
                            'string' => 'test',
                            'array' => ['a', 'b'],
                            'datetime' => '2025-02-02T12:23:00+00:00',
                        ],
                    ],
                    'objects' => [
                        ['type' => 'a', 'extraField' => 'extra', 'name' => 'name1'],
                        ['type' => 'b', 'number' => 12, 'name' => 'name2'],
                    ]
                ]
            ]
        ];
    }

    #[DataProvider('dataProvider')]
    public function testSerializePrimitive(mixed $object, array $expected): void
    {
        $result = Serializer::toJson($object);
        $this->assertSame(
            $expected,
            $result
        );
    }

    #[DataProvider('dataProvider')]
    public function testCanDeserialize(mixed $expected, array $serialized): void
    {
        $result = Serializer::fromJson(get_class($expected), $serialized);
        $this->assertEquals(
            $expected,
            $result
        );
    }
}

<?php

namespace Mwl91\Books\Tests\Unit;

use Carbon\Carbon;
use Mwl91\Books\Shared\AggregateChanged;
use Ramsey\Uuid\Uuid;

final class ConvertToPrimitivesTest extends \PHPUnit\Framework\TestCase
{
    public static function complexToPrimitives(): \Generator
    {
        yield [
            ['name' => 'John', 'age' => 30],
            ['name' => 'John', 'age' => 30]
        ];

        yield [
            ['date' => Carbon::make('2021-01-01 0:00'), 'id' => Uuid::fromString('f1f8b3b4-0b3b-4b3b-8b3b-0b3b4b3b0b3b')],
            ['date' => Carbon::make('2021-01-01 0:00')->format('c'), 'id' => 'f1f8b3b4-0b3b-4b3b-8b3b-0b3b4b3b0b3b']
        ];

        yield [
            [
                'collection' => [
                    ['date' => Carbon::make('2021-01-01 0:00'), 'id' => Uuid::fromString('f1f8b3b4-0b3b-4b3b-8b3b-0b3b4b3b0b3b')]
                ]
            ],
            [
                'collection' => [
                    ['date' => Carbon::make('2021-01-01 0:00')->format('c'), 'id' => 'f1f8b3b4-0b3b-4b3b-8b3b-0b3b4b3b0b3b']
                ]
            ]
        ];

        yield [
            ['obj' => new class {
                public string $name = 'John';
                public int $age = 30;
            }],
            ['obj' => '{"name":"John","age":30}']
        ];

        yield [
            [
                'collection' => [
                    'keys' => ['test', 'inny', 'jakiś'],
                    'obj' => new class {
                        public string $name = 'John';
                        public int $age = 30;
                    }
                ]
            ],
            [
                'collection' => [
                    'keys' => ['test', 'inny', 'jakiś'],
                    'obj' => '{"name":"John","age":30}'
                ]
            ]
        ];
    }

    /** @dataProvider complexToPrimitives */
    public function testItShouldConvertToPrimitives(array $input, array $output): void
    {
        $this->assertEquals($output, AggregateChanged::getPrimitives($input));
    }
}

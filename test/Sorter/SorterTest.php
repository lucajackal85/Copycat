<?php


namespace Jackal\Copycat\Tests\Sorter;


use Jackal\Copycat\Sorter\ValueSorter\AscendingSorter;
use Jackal\Copycat\Sorter\ValueSorter\DescendingSorter;
use PHPUnit\Framework\TestCase;

class SorterTest extends TestCase
{
    public function testAscendingSortColum(){

        $values = [
            ['a' => 2, ],
            ['a' => 1, ],
            ['a' => 3, ],
        ];
        $sorter = new AscendingSorter('a');
        $sorter($values);

        $this->assertEquals([
            ['a' => 1],
            ['a' => 2],
            ['a' => 3],
        ],$values);
    }

    public function testDescendingSortColum(){

        $values = [
            ['a' => 2, ],
            ['a' => 1, ],
            ['a' => 3, ],
        ];
        $sorter = new DescendingSorter('a');
        $sorter($values);

        $this->assertEquals([
            ['a' => 3],
            ['a' => 2],
            ['a' => 1],
        ],$values);
    }

    public function testAscendingSortMultiColum(){

        $values = [
            ['a' => 2, 'b' => 3],
            ['a' => 2, 'b' => 1],
            ['a' => 3, 'b' => 2],
            ['a' => 1, 'b' => 2],
        ];
        $sorter = new AscendingSorter('a','b');
        $sorter($values);

        $this->assertEquals([
            ['a' => 1,'b' => 2],
            ['a' => 2,'b' => 1],
            ['a' => 2,'b' => 3],
            ['a' => 3,'b' => 2],
        ],$values);
    }

    public function testDescendingSortMultiColum(){

        $values = [
            ['a' => 2, 'b' => 3],
            ['a' => 2, 'b' => 1],
            ['a' => 3, 'b' => 2],
            ['a' => 1, 'b' => 2],
        ];
        $sorter = new DescendingSorter('a','b');
        $sorter($values);

        $this->assertEquals([
            ['a' => 3,'b' => 2],
            ['a' => 2,'b' => 3],
            ['a' => 2,'b' => 1],
            ['a' => 1,'b' => 2],
        ],$values);
    }
}
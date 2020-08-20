<?php


namespace Jackal\Copycat\Tests\Sorter;


use Jackal\Copycat\Sorter\SorterMap;
use Jackal\Copycat\Sorter\ValueSorter\AscendingSorter;
use PHPUnit\Framework\TestCase;

class SorterMapTest extends TestCase
{
    public function testHasSorter(){

        $sorterMap = new SorterMap();
        $this->assertFalse($sorterMap->hasSorter());

        $sorterMap->add(new AscendingSorter('test'));

        $this->assertTrue($sorterMap->hasSorter());
    }

    public function testApplySorter(){

        $sorterMap = new SorterMap();
        $sorterMap->add(new AscendingSorter('test'));

        $values = [['test' => 3],['test' => 1],['test' => 2]];
        $sorterMap->apply($values);

        $this->assertEquals([['test' => 1],['test' => 2],['test' => 3]],$values);

    }


}
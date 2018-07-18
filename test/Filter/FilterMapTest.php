<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 18/07/18
 * Time: 23:22
 */

namespace Jackal\Copycat\Tests\Filter;

use Jackal\Copycat\Filter\FilterMap;
use PHPUnit\Framework\TestCase;

class FilterMapTest extends TestCase
{
    public function testReturnTrueWithMultipleFilters()
    {
        $filterMap = new FilterMap();

        $filterMap->add(function ($value) {
            return true;
        });

        $filterMap->add(function ($value) {
            return true;
        });

        $anyValue = ['xxx','yyy'];
        $this->assertTrue($filterMap->apply($anyValue));
    }

    public function testReturnFalseWithMultipleFilters()
    {
        $filterMap = new FilterMap();

        $filterMap->add(function ($value) {
            return true;
        });

        $filterMap->add(function ($value) {
            return false;
        });

        $anyValue = ['xxx','yyy'];
        $this->assertFalse($filterMap->apply($anyValue));
    }
}

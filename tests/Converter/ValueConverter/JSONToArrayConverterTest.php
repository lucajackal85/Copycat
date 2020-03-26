<?php

namespace Jackal\Copycat\Tests\Converter\ValueConverter;

use Jackal\Copycat\Converter\ValueConverter\JSONToArrayConverter;
use PHPUnit\Framework\TestCase;

class JSONToArrayConverterTest extends TestCase
{
    public function testArrayToJSON()
    {
        $converter = new JSONToArrayConverter('colA');

        $this->assertEquals(['colA' => ['valueA']], $converter(['colA' => '["valueA"]']));
    }
}

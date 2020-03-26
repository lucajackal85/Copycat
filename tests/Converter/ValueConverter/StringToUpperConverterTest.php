<?php

namespace Jackal\Copycat\Tests\Converter\ValueConverter;

use Jackal\Copycat\Converter\ValueConverter\StringToUpperConverter;
use PHPUnit\Framework\TestCase;

class StringToUpperConverterTest extends TestCase
{
    public function testStringToUpperConverter()
    {
        $converter = new StringToUpperConverter('a');
        $this->assertEquals(['a' => 'AEIOU'], $converter(['a' => 'aeiou']));

        $this->assertEquals(['a' => 'ÀÈÌÒÙ'], $converter(['a' => 'àèìòù']));
    }
}

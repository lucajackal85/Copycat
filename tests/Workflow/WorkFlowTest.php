<?php

namespace Jackal\Copycat\Tests\Workflow;

use Jackal\Copycat\Filter\ValueFilter\NotBlankFilter;
use Jackal\Copycat\Reader\ReaderInterface;
use Jackal\Copycat\Workflow;
use Jackal\Copycat\Writer\ArrayWriter;
use Jackal\Copycat\Writer\WriterInterface;
use PHPUnit\Framework\TestCase;

class WorkFlowTest extends TestCase
{
    public function testWorkFlow()
    {
        $arr = [
            ['1' => 'x'],
        ];
        $mockReader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $mockReader->expects($this->any())->method('valid')->willReturnOnConsecutiveCalls(true, false);
        $mockReader->expects($this->once())->method('current')->willReturn($arr[0]);
        $mockReader->expects($this->never())->method('all')->willReturn($arr);
        $mockWriter = $this->getMockBuilder(WriterInterface::class)->getMock();
        $mockWriter->expects($this->once())->method('writeItem');

        $workflow = new Workflow($mockReader);
        $workflow->addWriter($mockWriter);

        $workflow->process(function ($values) {
            $this->assertEquals(['1' => 'x'], $values);
        });
    }

    public function testRaiseExceptionOnWriterNotSet()
    {
        $this->expectException(\RuntimeException::class);

        $mockReader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $workflow = new Workflow($mockReader);

        $workflow->process();
    }

    public function testWorkFlowFilter()
    {
        $arr = [['col1' => null,'col2' => 'value6']];
        $mockReader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $mockReader->expects($this->any())->method('valid')->willReturnOnConsecutiveCalls(true, false);
        $mockReader->expects($this->never())->method('all')->willReturn($arr);
        $mockReader->expects($this->once())->method('current')->willReturn($arr[0]);
        $mockWriter = $this->getMockBuilder(WriterInterface::class)->getMock();
        $mockWriter->expects($this->never())->method('writeItem');

        $workflow = new Workflow($mockReader);
        $workflow->addFilter(new NotBlankFilter('col1'));
        $workflow->addWriter($mockWriter);
        $workflow->process();
    }

    public function testWithMultipleConverter()
    {
        $reader = new \Jackal\Copycat\Reader\ArrayReader([
            [
                'a' => 1,
                'b' => new \StdClass(),
                'c' => '2018-01-01',
                'd' => 'ciao',
                'e' => '[1,2,3]',
            ],
        ]);

        $workflow = new \Jackal\Copycat\Workflow($reader);

        $workflow->addWriter(new \Jackal\Copycat\Writer\ArrayWriter($ouputArray));

        $workflow->addWriter(new \Jackal\Copycat\Writer\JSONWriter($ouputJson));

        $workflow->addConverter(new \Jackal\Copycat\Converter\ValueConverter\ObjectToStringConverter('b'));
        $workflow->addConverter(new \Jackal\Copycat\Converter\ValueConverter\StringToDateTimeConverter('c'));
        $workflow->addConverter(new \Jackal\Copycat\Converter\ValueConverter\StringToUpperConverter('d'));
        $workflow->addConverter(new \Jackal\Copycat\Converter\ValueConverter\JSONToArrayConverter('e'));
        $workflow->process();

        $this->assertEquals([
            [
                'a' => 1,
                'b' => serialize(new \StdClass()),
                'c' => new \DateTime('2018-01-01'),
                'd' => 'CIAO',
                'e' => [1,2,3],
            ],
        ], $ouputArray);

        $this->assertEquals(1, json_decode($ouputJson, true)[0]['a']);
        $this->assertEquals(serialize(new \StdClass()), json_decode($ouputJson, true)[0]['b']);
        $this->assertEquals(
            [
                'date' => '2018-01-01 00:00:00.000000',
                'timezone_type' => 3,
                'timezone' => 'UTC',
            ],
            json_decode($ouputJson, true)[0]['c']
        );
        $this->assertEquals('CIAO', json_decode($ouputJson, true)[0]['d']);
    }

    public function testCustomConverter()
    {
        $reader = new \Jackal\Copycat\Reader\ArrayReader([
            [
                'a' => 'to convert',
                'b' => 2,
                'c' => 3,
            ],
        ]);

        $workflow = new \Jackal\Copycat\Workflow($reader);
        $workflow->addConverter(function ($values) {
            foreach ($values as &$value) {
                if ($value == 'to convert') {
                    $value = 'converted';
                }
            }

            return $values;
        });

        $workflow->addWriter(new ArrayWriter($arrayToWrite));
        $workflow->process();

        $this->assertEquals('converted', $arrayToWrite[0]['a']);
        $this->assertEquals(2, $arrayToWrite[0]['b']);
        $this->assertEquals(3, $arrayToWrite[0]['c']);
    }
}

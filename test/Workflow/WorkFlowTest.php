<?php


namespace Jackal\Copycat\Tests\Workflow;

use Jackal\Copycat\Filter\ValueFilter\NotBlankFilter;
use Jackal\Copycat\Reader\ReaderInterface;
use Jackal\Copycat\Workflow;
use Jackal\Copycat\Writer\WriterInterface;
use PHPUnit\Framework\TestCase;

class WorkFlowTest extends TestCase
{
    public function testWorkFlow()
    {
        $mockReader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $mockReader->expects($this->any())->method('valid')->willReturnOnConsecutiveCalls(true, false);
        $mockReader->expects($this->once())->method('current')->willReturn(['1' => 'x']);
        $mockWriter = $this->getMockBuilder(WriterInterface::class)->getMock();
        $mockWriter->expects($this->once())->method('writeItem');

        $workflow = new Workflow($mockReader);
        $workflow->addWriter($mockWriter);
        $workflow->process();
    }

    public function testRaiseExceptionOnWriterNotSet()
    {
        $this->expectException(\RuntimeException::class);

        $mockReader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $workflow = new Workflow($mockReader);

        $workflow->process();
    }

    public function testWorkFlowFilter(){

        $mockReader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $mockReader->expects($this->any())->method('valid')->willReturnOnConsecutiveCalls(true, false);
        $mockReader->expects($this->once())->method('current')->willReturn(
            ['col1' => null,'col2' => 'value6']
        );
        $mockWriter = $this->getMockBuilder(WriterInterface::class)->getMock();
        $mockWriter->expects($this->never())->method('writeItem');

        $workflow = new Workflow($mockReader);
        $workflow->addFilter(new NotBlankFilter('col1'));
        $workflow->addWriter($mockWriter);
        $workflow->process();
    }
}

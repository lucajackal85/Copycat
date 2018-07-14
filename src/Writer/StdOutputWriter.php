<?php


namespace Jackal\Copycat\Writer;


class StdOutputWriter implements WriterInterface
{

    protected function write($content){
        fwrite(STDOUT,$content);
    }
    public function prepare()
    {
        //do nothing
    }

    public function writeItem(array $item,$currentIndex,$totalElements)
    {
        $this->write(implode(', ',$item)."\n");
    }

    public function finish()
    {
        //do nothing
    }
}
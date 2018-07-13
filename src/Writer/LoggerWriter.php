<?php


namespace Jackal\Importer\Writer;


class LoggerWriter extends StdOutputWriter
{
    public function prepare()
    {
        $this->write('== START'."\n");
    }

    public function writeItem(array $item,$currentIndex,$totalElements)
    {
        $currentIndex = str_pad($currentIndex,strlen($totalElements),'0',STR_PAD_LEFT);
        $this->write('['.(new \DateTime('now'))->format('Y-m-d H:i:s').'] '.$currentIndex.'/'.$totalElements."\n");
    }

    public function finish()
    {
        $this->write('== FINISH!'."\n");
    }


}
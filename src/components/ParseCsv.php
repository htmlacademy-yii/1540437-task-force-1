<?php

namespace app\components;

class ParseCsv
{
    /** @var SplFileObject */
    private $fp;

    private $headers = null;
    private $data = null;

    public function __construct(\SplFileObject $spl, bool $withHeaders = true)
    {
        $this->fp = $spl;
        if ($withHeaders) {
            $this->headers = $this->getHeader();
        }

        $this->data = $this->getfileData();
    }

    private function getHeader(): array
    {
        $this->fp->rewind();
        return $this->fp->fgetcsv();
    }

    private function getfileData(): array
    {
        $result = [];
        while (!$this->fp->eof()) {
            $result[] = ($this->fp->fgetcsv());
        }

        return $result;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getData()
    {
        return $this->data;
    }
}

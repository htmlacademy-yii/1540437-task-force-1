<?php

namespace app\components\Convertor\Interfaces;

interface WriterInterface
{
    public function getPath();
    public function write();
}

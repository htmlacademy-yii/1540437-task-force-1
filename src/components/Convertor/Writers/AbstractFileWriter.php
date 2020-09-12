<?php

namespace app\components\Convertor\Writers;

abstract class AbstractFileWriter
{
    /**
     * Undocumented function
     *
     * @return string
     */
    abstract public function generate(): string;
}

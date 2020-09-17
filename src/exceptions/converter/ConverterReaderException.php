<?php

namespace app\exceptions\converter;

class ConverterReaderException extends BaseConverterException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

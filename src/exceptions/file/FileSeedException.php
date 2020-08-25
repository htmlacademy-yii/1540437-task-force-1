<?php

namespace app\exceptions\file;

class FileSeedException extends \Exception
{
    /**
     * FileSeedException класс
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

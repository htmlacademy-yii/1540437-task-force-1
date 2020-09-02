<?php
namespace app\exceptions\converter;

class TypeOfConvertException extends BaseConverterException
{
    public function __construct(string $type)
    {
        $message = "Объект должен быть инстансом `{$type}`";
        parent::__construct($message);
    }
}

<?php

class DataTransferInterfaceException extends \Exception
{
    public function __construct(Object $object, string $intrefaceName)
    {
        $class = get_class($object);
        $message = "Класс '{$class}' должен быть интерфейсом `{$intrefaceName}`";
        
        parent::__construct($message);
    }
}

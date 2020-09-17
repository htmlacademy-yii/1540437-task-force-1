<?php
namespace app\exceptions\base;

class NotFoundPropertyExceptions extends \Exception
{
    /**
     * NotFoundPropertyExceptions конструктор
     *
     * @param string $property
     * @param string $className
     */
    public function __construct(string $property, string $className)
    {
        $message = "В классе `{$className}` не определено свойство `{$property}`";
        parent::__construct($message);
    }
}

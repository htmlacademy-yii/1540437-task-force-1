<?php

namespace app\components\Convertor\Interfaces;

use app\components\Convertor\interfaces\DataTransferInterface;

interface ReaderInterface
{
    /** @return string Имя источника */
    public function getSourceName(): string;

    /** @return DataTransferInterface */
<<<<<<< HEAD
    public function getData(): DataTransferInterface;
=======
    public function getDto(): DataTransferInterface;
>>>>>>> 37da8738c7d731e74af13a60327ab798e30b20a8
}

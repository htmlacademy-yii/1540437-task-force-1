<?php

namespace app\components\Convertor\Interfaces;

use app\components\Convertor\interfaces\DataTransferInterface;

interface WriterInterface
{
    /** @param DataTransferInterface $dataObject Объект данных */
    public function setData(DataTransferInterface $dataObject);

    /**
     * Сохранить данные в фаиле
     *
<<<<<<< HEAD
=======
     * @param string $filename
>>>>>>> 37da8738c7d731e74af13a60327ab798e30b20a8
     * @param string $data
     * @return int Колво записанных байт
     */
    public function saveAsFile(string $data): int;

    /** @return string */
    public function generate(): string;
}

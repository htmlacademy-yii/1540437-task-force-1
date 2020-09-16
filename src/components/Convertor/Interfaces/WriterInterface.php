<?php

namespace app\components\Convertor\Interfaces;

interface WriterInterface
{
    /**
     * @param DataTransferInterface $dataObject Объект данных
     * @return self
     */
    public function withData(DataTransferInterface $dataObject);

    /**
     * Сохранить данные в фаиле
     *
     * @return int Кол-во записанных байт
     */
    public function save(): int;
}

<?php

namespace app\components\Convertor\Writers;

abstract class AbstractFileWriter
{
    /**
     * Undocumented function
     *
     * @param array $dataRows
     * @return string
     */
    abstract public function generate(array $dataRows): string;

    /**
     * Генерирует новое имя на базе имени файла
     *
     * @param string $reader
     * @return string
     */
    abstract public function generateFileName(string $name): string;

    /**
     * Сохранить данные в фаиле
     *
     * @param string $filename
     * @param string $data
     * @return int Колво записанных байт
     */
    abstract public function saveAsFile(string $filename, string $data):int;
}

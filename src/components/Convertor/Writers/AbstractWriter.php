<?php
namespace app\components\Convertor\Writers;

use app\components\Convertor\Readers\AbstractFileReader;

abstract class AbstractWriter
{
    abstract public function generate(AbstractFileReader $reader): string;

    /**
     * Генерирует новое имя на базе имени файла
     *
     * @param AbstractFileReader $reader
     * @return string
     */
    abstract public function generateFileName(AbstractFileReader $reader): string;

    /**
     * Сохранить данные в фаиле
     *
     * @param string $filename
     * @param string $data
     * @return int Колво записанных байт
     */

    abstract public function saveAsFile(string $filename, string $data):int;
}

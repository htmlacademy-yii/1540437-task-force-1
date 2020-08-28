<?php

namespace app\components;

abstract class AbstractFileWrapper
{
    private $_spl;

    /**
     * AbstractFileParser function
     *
     * @param string $fileName
     * @param string $fileMod По умолчанию "r"
     */
    public function __construct(string $fileName, string $fileMod = 'r')
    {
        $this->_spl = new \SplFileObject($fileName, $fileMod);
    }

    /**
     * Обрезает файл до заданной длины.
     *
     * @param int $size По умолчанию 0
     * @return bool
     */
    public function truncate(int $size = 0): bool
    {
        return $this->getFile()->ftruncate($size);
    }

    /** @return \SplFileObject */
    protected function getFile(): \SplFileObject
    {
        return $this->_spl;
    }

    /** @return \SplFileInfo */
    protected function getFileInfo(): \SplFileInfo
    {
        return $this->getFile()->getFileInfo();
    }

    /** @return int Размер файла в Байтах */
    protected function getFileSize(): int
    {
        return $this->getFileInfo()->getSize();
    }

    /** Установить курсор в начало строки */
    protected function reset(): void
    {
        $this->getFile()->rewind();
    }

    /** @return int Номер следующей строки */
    protected function next(): int
    {
        $this->getFile()->next();
        return $this->current();
    }

    /** @return int Номер предыдущей строки */
    protected function prev(): int
    {
        $currentLine = $this->current();
        if ($currentLine > 0) {
            $currentLine--;
        }
        return $currentLine;
    }

    /** @return int Номер текущей строки */
    protected function current(): int
    {
        return $this->getFile()->key();
    }

    /**
     * Перемещение к указанной строке
     *
     * @param int $line
     * @return void
     */
    protected function moveTo(int $line): void
    {
        $this->getFile()->seek($line);
    }

    /**
     * Считать первую строку файла.
     * Если сохраняем указатель, то после прочтения первой строки,
     * возвращаем указатель на свое место, в противном случаи
     * смещаемся на следующую строку.
     *
     * @param bool $backToCurrentCursor
     * @return string|array|null  */
    abstract public function getFirstLine(bool $backToCurrentCursor = true);

    /** @return string|array|null Читает текущую строку */
    abstract public function getCurrentLine();

    /** @return iterable|null Чтение до завершения конца файла */
    abstract public function getNextLine(): ?iterable;
}

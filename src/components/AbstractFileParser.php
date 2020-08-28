<?php

namespace app\components;

abstract class AbstractFileParser
{
    /** @var \SplFileObject */
    private $_spl;

    /**
     * AbstractFileParser function
     *
     * @param string $fileName
     * @param string $fileMod
     */
    public function __construct(string $fileName, string $fileMod = 'r')
    {
        $this->_spl = new \SplFileObject($fileName, $fileMod);
    }

    /**
     * Обрезает файл до заданной длины
     *
     * @param int $size
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

    protected function getFileInfo()
    {
        return $this->getFile()->getFileInfo();
    }

    /** Установить курсор в начало строки */
    protected function reset(): void
    {
        $this->getFile()->rewind();
    }

    /** @return int Номер следующей строки */
    protected function next() : int
    {
        $this->getFile()->next();
        return $this->current();
    }

    /** @return int Номер предыдущей строки */
    protected function prev(): int
    {
        $currentLinePos = $this->current();
        if ($currentLinePos > 0) {
            $currentLinePos--;
        }
        return $currentLinePos;
    }

    /** Текущий номер строки */
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

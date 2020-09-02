<?php
namespace app\components\Convertor\Readers;

/**
 * AbstractFileReader Abstract class
 *
 * @method \SplFileObject getFile()
 * @method void reset() Установить курсор в начало строки
 * @method int next() Номер следующей строки
 * @method int prev() Номер предыдущей строки
 * @method int current() Номер текущей строки
 */
abstract class AbstractFileReader
{
    /** @var \SplFileObject $spl */
    protected $spl;

    /**
     * Обект класса чтения файлов
     *
     * @return \SplFileObject
     */
    protected function getFile(): \SplFileObject
    {
        return $this->spl;
    }

    protected function reset(): void
    {
        $this->getFile()->rewind();
    }

    protected function next(): ?int
    {
        return $this->getFile()->eof() ? null : $this->current()+1;
    }

    protected function prev(): int
    {
        $currentLine = $this->current();
        if ($currentLine > 0) {
            $currentLine--;
        }
        return $currentLine;
    }

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
     * Установить Объект класса чтения файлов \SplFileObject
     *
     * @param string $fileName
     * @param string|null $fileMod
     * @return void
     */
    abstract public function setFile(string $fileName, string $fileMod = 'r');

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

    /**
     * Имя файла
     *
     * @param boolean $withExtension По умолчанию true
     * @return string
     */
    abstract public function getFileName(bool $withExtension = true): string;

    /** @return string Расширение файла */
    abstract public function getFileExtension(): string;

    /** @return array Колонки файла */
    abstract public function getColumns(): array;

    /**
     * Массив строк файла
     *
     * @return array Массив строк в файле
     */
    abstract public function getRows(): array;
}

<?php

namespace app\components\Convertor\interfaces;

interface DataTransferInterface
{
    /** @return string Имя объекта данных */
    public function getName(): string;

    /** @return array|null Заголовки данных */
    public function getHeads(): ?array;

    /** @return array Колонки */
    public function getData(): array;

    /** @param string $name Имя объекта данных */
    public function setName(string $name);

    /** @param array $heads Задать заголовки данных */
    public function setHeads(array $heads);

    /** @param int|null Кол-во строк */
    public function setData(array $data): ?int;
}

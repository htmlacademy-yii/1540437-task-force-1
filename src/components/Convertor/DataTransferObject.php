<?php

namespace app\components\Convertor;

use app\components\Convertor\interfaces\DataTransferInterface;

class DataTransferObject implements DataTransferInterface
{
    /** @var string Имя объекта данных */
    private $name;
    private $data;
    private $heads = null;

    /** @return bool  */
    private function validateData(array $data): bool
    {
        $validate = true;
        if ($this->heads !== null) {
            $countHeads = count($this->heads);
            $countData = count($data[0]);
            if ($countData !== $countHeads) {
                $validate = false;
            }
        }

        return $validate;
    }

    /** {@inheritDoc} */
    public function setData(array $data): ?int
    {
        if ($this->validateData($data)) {
            $this->data = $data;
            return count($this->data);
        }
        return null;
    }

    /** {@inheritDoc} */
    public function setHeads(array $heads)
    {
        $this->heads = $heads;
    }

    /** {@inheritDoc} */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /** {@inheritDoc } */
    public function getName(): string
    {
        return $this->name;
    }

    /** {@inheritDoc } */
    public function getHeads(): ?array
    {
        return $this->heads;
    }

    /** {@inheritDoc } */
    public function getData(): array
    {
        return $this->data;
    }
}

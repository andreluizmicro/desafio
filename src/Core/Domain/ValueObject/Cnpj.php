<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\ValueObject;

use Transfer\Core\Domain\Exception\InvalidCnpjException;

class Cnpj
{
    /**
     * @throws InvalidCnpjException
     */
    public function __construct(public string $value)
    {
        $this->validate();
    }

    /**
     * @throws InvalidCnpjException
     */
    private function validate(): void
    {
        if (! $this->isValid()) {
            throw InvalidCnpjException::invalidCnpj($this->value);
        }
    }

    private function isValid(): bool
    {
        $cnpj = str_replace(['.', '-', '/'], '', $this->value);

        if (preg_match('/^\d{14}$/', $cnpj)) {
            return true;
        }

        return false;
    }
}

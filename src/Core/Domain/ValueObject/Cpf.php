<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\ValueObject;

use Transfer\Core\Domain\Exception\InvalidCpfException;

final readonly class Cpf
{
    /**
     * @throws InvalidCpfException
     */
    public function __construct(public string $value)
    {
        $this->validate();
    }

    /**
     * @throws InvalidCpfException
     */
    private function validate(): void
    {
        if (! $this->isValid()) {
            throw InvalidCpfException::invalidCpf($this->value);
        }
    }

    private function isValid(): bool
    {
        $cpf = str_replace(['.', '-'], '', $this->value);

        if (preg_match('/^\d{11}$/', $cpf)) {
            return true;
        }

        return false;
    }
}

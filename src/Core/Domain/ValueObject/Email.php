<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\ValueObject;

use Transfer\Core\Domain\Exception\InvalidEmailException;

final readonly class Email
{
    /**
     * @throws InvalidEmailException
     */
    public function __construct(public string $value)
    {
        $this->validate();
    }

    /**
     * @throws InvalidEmailException
     */
    private function validate(): void
    {
        if (! filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::invalidEmail($this->value);
        }
    }
}

<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\ValueObject;

use Transfer\Core\Domain\Exception\InvalidPasswordException;

final class Password
{
    private const MIN_LENGTH = 8;

    /**
     * @throws InvalidPasswordException
     */
    public function __construct(public string $value)
    {
        $this->validate();
        $this->value = $this->hash($this->value);
    }

    /**
     * @throws InvalidPasswordException
     */
    private function validate(): void
    {
        if (! $this->isValid()) {
            throw InvalidPasswordException::invalidPassword($this->value);
        }
    }

    private function isValid(): bool
    {
        return strlen($this->value) >= self::MIN_LENGTH && preg_match('/(?=.*[a-z])(?=.*[A-Z])/', $this->value);
    }

    public function hash(string $rawPassword): string
    {
        return password_hash($rawPassword, PASSWORD_DEFAULT);
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

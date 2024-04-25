<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\ValueObject;

use Transfer\Core\Domain\Exception\InvalidNameException;

final readonly class Name
{
    private const MIN_LENGTH = 3;

    private const MAX_LENGTH = 255;

    /**
     * @throws InvalidNameException
     */
    public function __construct(public string $value)
    {
        $this->validate();
    }

    /**
     * @throws InvalidNameException
     */
    private function validate(): void
    {
        if (strlen($this->value) < self::MIN_LENGTH || strlen($this->value) > self::MAX_LENGTH) {
            throw InvalidNameException::invalidName($this->value);
        }
    }
}

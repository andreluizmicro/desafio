<?php

declare(strict_types=1);

namespace Transfer\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Transfer\Core\Domain\Exception\InvalidIDException;

class Id
{
    /**
     * @throws InvalidIDException
     */
    public function __construct(
        public string $value,
    ) {
        $this->validate($this->value);
    }

    /**
     * @throws InvalidIDException
     */
    public static function random(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidIDException
     */
    private function validate(string $id): void
    {
        if (! Uuid::isValid($id)) {
            throw InvalidIDException::invalidId($id);
        }
    }
}

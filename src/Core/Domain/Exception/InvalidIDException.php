<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Exception;

class InvalidIDException extends DomainException
{
    public static function invalidId(string $number): self
    {
        return new self(
            sprintf('The id %s is invalid.', $number)
        );
    }
}

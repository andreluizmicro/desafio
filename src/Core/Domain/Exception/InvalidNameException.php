<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Exception;

class InvalidNameException extends DomainException
{
    public static function invalidName(string $name): self
    {
        return new self(
            sprintf('The name %s is invalid', $name)
        );
    }
}

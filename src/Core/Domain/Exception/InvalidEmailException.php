<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Exception;

class InvalidEmailException extends DomainException
{
    public static function invalidEmail(string $email): self
    {
        return new self(
            sprintf('The email %s is invalid.', $email)
        );
    }
}

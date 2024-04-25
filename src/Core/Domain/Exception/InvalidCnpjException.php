<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Exception;

class InvalidCnpjException extends DomainException
{
    public static function invalidCnpj(string $number): self
    {
        return new self(
            sprintf('The cnpj %s is invalid.', $number)
        );
    }
}

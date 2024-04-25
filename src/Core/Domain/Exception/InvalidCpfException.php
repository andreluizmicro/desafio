<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Exception;

class InvalidCpfException extends DomainException
{
    public static function invalidCpf(string $number): self
    {
        return new self(
            sprintf('The cpf %s is invalid.', $number)
        );
    }
}

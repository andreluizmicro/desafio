<?php

declare(strict_types=1);

namespace Transfer\Core\Application\User;

class Input
{
    public function __construct(
        public string $name,
        public string $cpf,
        public string $email,
        public string $password,
        public int $userType,
        public ?string $cnpj = null,
    ) {
    }
}

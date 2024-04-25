<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Entity;

use Transfer\Core\Domain\ValueObject\Cpf;
use Transfer\Core\Domain\ValueObject\Email;
use Transfer\Core\Domain\ValueObject\Name;
use Transfer\Core\Domain\ValueObject\Password;

class User
{
    public function __construct(
        public Name $name,
        public Cpf $cpf,
        public Email $email,
        public Password $password,
    ) {
    }
}

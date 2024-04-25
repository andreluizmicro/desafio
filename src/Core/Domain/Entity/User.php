<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Entity;

use Transfer\Core\Domain\Enum\UserType;
use Transfer\Core\Domain\Exception\InvalidIDException;
use Transfer\Core\Domain\ValueObject\Cnpj;
use Transfer\Core\Domain\ValueObject\Cpf;
use Transfer\Core\Domain\ValueObject\Email;
use Transfer\Core\Domain\ValueObject\Name;
use Transfer\Core\Domain\ValueObject\Password;
use Transfer\Shared\Domain\ValueObject\Id;

class User
{
    /**
     * @throws InvalidIDException
     */
    public function __construct(
        public Name $name,
        public Cpf $cpf,
        public Email $email,
        public Password $password,
        public UserType $userType,
        public ?Id $id = null,
        public ?Cnpj $cnpj = null,
    ) {
        $this->id = $this->id ?? Id::random();
    }
}

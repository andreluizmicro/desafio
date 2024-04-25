<?php

declare(strict_types=1);

namespace Transfer\Core\Application\User;

use Transfer\Core\Domain\Entity\User;
use Transfer\Core\Domain\Enum\UserType;
use Transfer\Core\Domain\Exception\InvalidCnpjException;
use Transfer\Core\Domain\Exception\InvalidCpfException;
use Transfer\Core\Domain\Exception\InvalidEmailException;
use Transfer\Core\Domain\Exception\InvalidIDException;
use Transfer\Core\Domain\Exception\InvalidNameException;
use Transfer\Core\Domain\Exception\InvalidPasswordException;
use Transfer\Core\Domain\Repository\UserRepositoryInterface;
use Transfer\Core\Domain\ValueObject\Cnpj;
use Transfer\Core\Domain\ValueObject\Cpf;
use Transfer\Core\Domain\ValueObject\Email;
use Transfer\Core\Domain\ValueObject\Name;
use Transfer\Core\Domain\ValueObject\Password;

readonly class CreateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @throws InvalidPasswordException
     * @throws InvalidIDException
     * @throws InvalidEmailException
     * @throws InvalidCpfException
     * @throws InvalidNameException
     * @throws InvalidCnpjException
     */
    public function execute(Input $input): Output
    {
        $user = new User(
            name: new Name($input->name),
            cpf: new Cpf($input->cpf),
            email: new Email($input->email),
            password: new Password($input->password),
            userType: UserType::tryFrom($input->userType),
            cnpj: $input->cnpj ? new Cnpj($input->cnpj) : null,
        );

        $userCreatedId = $this->userRepository->create($user);

        return new Output($userCreatedId->value);
    }
}

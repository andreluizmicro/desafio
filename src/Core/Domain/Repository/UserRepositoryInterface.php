<?php

declare(strict_types=1);

namespace Transfer\Core\Domain\Repository;

use Transfer\Core\Domain\Entity\User;
use Transfer\Shared\Domain\ValueObject\Id;

interface UserRepositoryInterface
{
    public function create(User $user): Id;
}

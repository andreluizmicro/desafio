<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\User;

use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;
use Transfer\Core\Application\User\CreateUserService;
use Transfer\Core\Application\User\Input;
use Transfer\Core\Domain\Repository\UserRepositoryInterface;
use Transfer\Shared\Domain\ValueObject\Id;

class CreateUserServiceTest extends TestCase
{
    public function testShouldCreateUser(): void
    {
        $inputMock = Mockery::mock(Input::class, [
            'André Luiz',
            '893.584.030-04',
            'andreluizmicro@gmail.com',
            'fakePassword123',
            1,
            null,
        ]);

        $userRepositoryMock = Mockery::mock(stdClass::class, UserRepositoryInterface::class);
        $userRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->andReturn(Id::random());

        $createUserService = new CreateUserService($userRepositoryMock);

        $output = $createUserService->execute($inputMock);
        $this->assertNotEmpty($output->id);
    }
}

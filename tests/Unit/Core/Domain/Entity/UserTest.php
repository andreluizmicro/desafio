<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Transfer\Core\Domain\Entity\User;
use Transfer\Core\Domain\Exception\InvalidCpfException;
use Transfer\Core\Domain\Exception\InvalidEmailException;
use Transfer\Core\Domain\Exception\InvalidNameException;
use Transfer\Core\Domain\Exception\InvalidPasswordException;
use Transfer\Core\Domain\ValueObject\Cpf;
use Transfer\Core\Domain\ValueObject\Email;
use Transfer\Core\Domain\ValueObject\Name;
use Transfer\Core\Domain\ValueObject\Password;

class UserTest extends TestCase
{
    public function testShouldCreateUser(): void
    {
        $data = [
            'name' => 'André Luiz',
            'cpf' => '893.584.030-04',
            'email' => 'andreluizmicro@gmail.com',
            'password' => 'fakePassword123',
        ];

        $user = new User(
            name: new Name($data['name']),
            cpf: new Cpf($data['cpf']),
            email: new Email($data['email']),
            password: new Password($data['password']),
        );

        $this->assertEquals($data['name'], $user->name->value);
        $this->assertEquals($data['cpf'], $user->cpf->value);
        $this->assertEquals($data['email'], $user->email->value);
        $this->assertNotEquals($data['password'], $user->password);
        $this->assertTrue($user->password->verify($data['password'], $user->password->value));
    }

    /**
     * @dataProvider invalidUserProvider
     */
    public function testShouldReturnExceptionCreateUser(array $data): void
    {
        $this->expectException($data['expected_exception']);
        new User(
            name: new Name($data['name']),
            cpf: new Cpf($data['cpf']),
            email: new Email($data['email']),
            password: new Password($data['password']),
        );
    }

    public static function invalidUserProvider(): iterable
    {
        yield [
            [
                'name' => 'oi',
                'cpf' => '893.584.030-04',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'Password6987654',
                'expected_exception' => InvalidNameException::class,
            ],
        ];

        yield [
            [
                'name' => 'André Luiz',
                'cpf' => '00000000',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'Password6987654',
                'expected_exception' => InvalidCpfException::class,
            ],
        ];

        yield [
            [
                'name' => 'André Luiz',
                'cpf' => '893.584.030-04',
                'email' => 'aaa',
                'password' => 'Password6987654',
                'expected_exception' => InvalidEmailException::class,
            ],
        ];

        yield [
            [
                'name' => 'André Luiz',
                'cpf' => '893.584.030-04',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'aaa',
                'expected_exception' => InvalidPasswordException::class,
            ],
        ];
    }
}

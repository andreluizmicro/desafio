<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Transfer\Core\Domain\Entity\User;
use Transfer\Core\Domain\Enum\UserType;
use Transfer\Core\Domain\Exception\InvalidCnpjException;
use Transfer\Core\Domain\Exception\InvalidCpfException;
use Transfer\Core\Domain\Exception\InvalidEmailException;
use Transfer\Core\Domain\Exception\InvalidIDException;
use Transfer\Core\Domain\Exception\InvalidNameException;
use Transfer\Core\Domain\Exception\InvalidPasswordException;
use Transfer\Core\Domain\ValueObject\Cnpj;
use Transfer\Core\Domain\ValueObject\Cpf;
use Transfer\Core\Domain\ValueObject\Email;
use Transfer\Core\Domain\ValueObject\Name;
use Transfer\Core\Domain\ValueObject\Password;
use Transfer\Shared\Domain\ValueObject\Id;

class UserTest extends TestCase
{
    public function testShouldCreateUser(): void
    {
        $data = [
            'name' => 'André Luiz',
            'cpf' => '893.584.030-04',
            'email' => 'andreluizmicro@gmail.com',
            'password' => 'fakePassword123',
            'user_type' => 1,
            'cnpj' => '84.644.059/0001-02',
        ];

        $user = new User(
            name: new Name($data['name']),
            cpf: new Cpf($data['cpf']),
            email: new Email($data['email']),
            password: new Password($data['password']),
            userType: UserType::tryFrom($data['user_type']),
            cnpj: new Cnpj($data['cnpj']),
        );

        $this->assertNotEmpty($user->id->value);
        $this->assertEquals($data['name'], $user->name->value);
        $this->assertEquals($data['cpf'], $user->cpf->value);
        $this->assertEquals($data['email'], $user->email->value);
        $this->assertNotEquals($data['password'], $user->password);
        $this->assertTrue($user->password->verify($data['password'], $user->password->value));
        $this->assertEquals('Comum', $user->userType->label());
        $this->assertNotEmpty($user->id->toString());
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
            userType: UserType::shopkeeperUser,
            id: new Id($data['id']),
            cnpj: new Cnpj($data['cnpj']) ?? null,
        );
    }

    public static function invalidUserProvider(): iterable
    {
        yield [
            [
                'id' => 'bae75869-7a44-45d5-98b9-004d653b0ba1',
                'name' => 'oi',
                'cpf' => '893.584.030-04',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'Password6987654',
                'user_type' => 1,
                'expected_exception' => InvalidNameException::class,
            ],
        ];

        yield [
            [
                'id' => 'bae75869-7a44-45d5-98b9-004d653b0ba1',
                'name' => 'André Luiz',
                'cpf' => '00000000',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'Password6987654',
                'user_type' => 1,
                'expected_exception' => InvalidCpfException::class,
            ],
        ];

        yield [
            [
                'id' => 'bae75869-7a44-45d5-98b9-004d653b0ba1',
                'name' => 'André Luiz',
                'cpf' => '893.584.030-04',
                'email' => 'aaa',
                'password' => 'Password6987654',
                'user_type' => 1,
                'expected_exception' => InvalidEmailException::class,
            ],
        ];

        yield [
            [
                'id' => 'bae75869-7a44-45d5-98b9-004d653b0ba1',
                'name' => 'André Luiz',
                'cpf' => '893.584.030-04',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'aaa',
                'user_type' => 1,
                'expected_exception' => InvalidPasswordException::class,
            ],
        ];

        yield [
            [
                'id' => 'bae75869-7a44-45d5-98b9-004d653b0ba1',
                'name' => 'André Luiz',
                'cpf' => '893.584.030-04',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'Password6987654',
                'user_type' => 2,
                'cnpj' => '000000000',
                'expected_exception' => InvalidCnpjException::class,
            ],
        ];

        yield [
            [
                'id' => 'fake_id',
                'name' => 'André Luiz',
                'cpf' => '893.584.030-04',
                'email' => 'andreluizmicro@gmail.com',
                'password' => 'Password6987654',
                'user_type' => 2,
                'cnpj' => '84.644.059/0001-02',
                'expected_exception' => InvalidIDException::class,
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestBase extends WebTestCase
{
    use FixturesTrait;
    use RecreateDatabaseTrait;

    protected static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $peter = null;
    protected static ?KernelBrowser $brian = null;
    protected static ?KernelBrowser $roger = null;

    protected function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameters(
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_ACCEPT' => 'application/ld+json',
                ]
            );
        }

        if (null === self::$peter) {
            self::$peter = clone self::$client;
            $this->createAuthenticatedUser(self::$peter, 'peter@api.com');
        }

        if (null === self::$brian) {
            self::$brian = clone self::$client;
            $this->createAuthenticatedUser(self::$brian, 'brian@api.com');
        }

        if (null === self::$roger) {
            self::$roger = clone self::$client;
            $this->createAuthenticatedUser(self::$roger, 'roger@api.com');
        }
    }

    private function createAuthenticatedUser(KernelBrowser &$client, string $email): void
    {
        $user = $this->getContainer()->get('App\Repository\UserRepository')->findOneByEmailOrFail($email);
        $token = $this
            ->getContainer()
            ->get('Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface')
            ->create($user);

        $client->setServerParameters(
            [
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json',
            ]
        );
    }

    protected function getResponseData(Response $response): array
    {
        return \json_decode($response->getContent(), true);
    }

    protected function initDbConnection(): Connection
    {
        return $this->getContainer()->get('doctrine')->getConnection();
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getPeterId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "peter@api.com"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getPeterGroupId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user_group WHERE name = "Peter Group"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getPeterExpenseCategoryId()
    {
        return $this->initDbConnection()->query('SELECT id FROM category WHERE name = "Peter Expense Category"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getPeterGroupExpenseCategoryId()
    {
        return $this->initDbConnection()->query('SELECT id FROM category WHERE name = "Peter Group Expense Category"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getPeterMovementId()
    {
        return $this->initDbConnection()->query('SELECT id FROM movement WHERE amount = 100')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getPeterGroupMovementId()
    {
        return $this->initDbConnection()->query('SELECT id FROM movement WHERE amount = 1000')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "brian@api.com"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianGroupId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user_group WHERE name = "Brian Group"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianExpenseCategoryId()
    {
        return $this->initDbConnection()->query('SELECT id FROM category WHERE name = "Brian Expense Category"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianGroupExpenseCategoryId()
    {
        return $this->initDbConnection()->query('SELECT id FROM category WHERE name = "Brian Group Expense Category"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianMovementId()
    {
        return $this->initDbConnection()->query('SELECT id FROM movement WHERE amount = 200')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianGroupMovementId()
    {
        return $this->initDbConnection()->query('SELECT id FROM movement WHERE amount = 2000')->fetchColumn(0);
    }
}

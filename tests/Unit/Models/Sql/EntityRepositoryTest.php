<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Site1\Models\Sql\EntityRepository;
use Romchik38\Server\Models\DatabasePostgresql;


class EntityRepositoryTest extends TestCase {

    private $database;

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabasePostgresql::class);
    }

    public function testCreate() {
        $repository = new EntityRepository();
    }
}
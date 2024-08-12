<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\CompositeId\CompositeIdRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\ModelFactory;
use Romchik38\Server\Models\CompositeId\CompositeIdFactory;
use Romchik38\Server\Models\CompositeId\CompositeIdModel;

class CompositeIdRepositoryTest extends TestCase
{
    private $database;
    private $factory;
    private $idFactory;
    private string $table = 'composite_id_table';

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabasePostgresql::class);
        $this->factory = $this->createMock(ModelFactory::class);
        $this->idFactory = $this->createMock(CompositeIdFactory::class);
    }

    protected function createRepository(): CompositeIdRepository
    {
        return new CompositeIdRepository(
            $this->database,
            $this->factory,
            $this->idFactory,
            $this->table
        );
    }

    public function testCreate() {
        $repository = $this->createRepository();
        $entity = $repository->create();

        $this->assertSame(true, $entity instanceof(CompositeIdModel::class));
    }
}

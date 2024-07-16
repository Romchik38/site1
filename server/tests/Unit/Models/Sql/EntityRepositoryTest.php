<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\Entity\EntityRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\Sql\Entity\EntityFactory;
use Romchik38\Server\Models\Sql\Entity\EntityModel;


class EntityRepositoryTest extends TestCase {

    private $database;
    private $factory;
    private $entityTable = 'entities';
    private $fieldsTable = 'entity_field';
    private $primaryEntityFieldName = 'entity_id';
    private $entityFieldName = 'field_name';
    private $entityValueName = 'value';

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabasePostgresql::class);
        $this->factory = $this->createMock(EntityFactory::class);
    }

    protected function createRepository():EntityRepository {
       return new EntityRepository(
            $this->database,
            $this->factory,
            $this->entityTable,
            $this->fieldsTable,
            $this->primaryEntityFieldName,
            $this->entityFieldName,
            $this->entityValueName
        );
    }

    /**
     * Testing method create
     */
    public function testCreate() {
        $repository = $this->createRepository();
        $entity = new EntityModel();
        $this->factory->method('create')->willReturn($entity);
        $this->assertSame($entity, $repository->create());
    }
}
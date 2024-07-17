<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\Entity\EntityRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\EntityFactory;
use Romchik38\Server\Models\EntityModel;
use Romchik38\Server\Models\Errors\QueryExeption;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\CouldNotAddException;


class EntityRepositoryTest extends TestCase
{

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

    protected function createRepository(): EntityRepository
    {
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
    public function testCreate()
    {
        $repository = $this->createRepository();
        $entity = new EntityModel();
        $this->factory->method('create')->willReturn($entity);
        $this->assertSame($entity, $repository->create());
    }

    /**
     * getById with Existing Id
     */
    public function testGetById()
    {
        $repository = $this->createRepository();
        $id = 1;
        $fieldNameEmail = 'email_contact_recovery';
        $fieldValueEmail = 'some@mail.com';

        $fieldsRow = [
            [
                'field_name' => $fieldNameEmail,
                'entity_id' => '1',
                'value' => $fieldValueEmail
            ],
            [
                'field_name' => 'min_order_sum',
                'entity_id' => '1',
                'value' => '100'
            ],

        ];

        $entityRow = [
            [$this->primaryEntityFieldName => '1', 'name' => 'Test Entity for getById method']
        ];

        $this->database->expects($this->exactly(2))->method('queryParams')
            ->willReturn($entityRow, $fieldsRow);

        $entity = new EntityModel();
        $this->factory->method('create')->willReturn($entity);

        $result = $repository->getById($id);

        $this->assertSame($fieldValueEmail, $result->email_contact_recovery);
    }

    /**
    * getById with not existing Id
    */ 
    public function testGetByIdNotFound()
    {
        $repository = $this->createRepository();
        $id = 1;

        $this->database->expects($this->once())->method('queryParams')
            ->willReturn([]);

        $this->expectException(NoSuchEntityException::class);

        $repository->getById($id);

    }

    /**
     * Add new Entity
     * pass
     */
    public function testAdd(){
        $repository = $this->createRepository();
        $entity = new EntityModel();
        $entity->setEntityData('name', 'Test Entity for add method');
        $entity->email_contact_recovery = 'some@email';

        $fieldsRow = [
            ['field_name' => 'email_contact_recovery', 
            'value' => 'some@email']
        ];

        $entityRow = [
            [$this->primaryEntityFieldName => '1', 'name' => 'Test Entity for add method']
        ];

        $this->factory->method('create')->willReturn(new EntityModel());

        $this->database->expects($this->exactly(2))->method('queryParams')
            ->willReturn($entityRow, $fieldsRow);

        $result = $repository->add($entity);

        $this->assertSame(
            $entityRow[0][$this->primaryEntityFieldName],
            $result->getEntityData($this->primaryEntityFieldName)
        );

        $this->assertSame(
            $fieldsRow[0][$this->entityValueName],
            $result->email_contact_recovery
        );
        
    }

    /**
     * Add new Entity
     * entity data is empty, so throw an error
    */
    public function testAddEntityDataEmptyThrowError(){
        $repository = $this->createRepository();
        $entity = new EntityModel();

        $this->expectException(CouldNotAddException::class);

        $repository->add($entity);
    }

    /**
     * Add new Entity
     * database throw an error
     */
    public function testAddDatabaseThrowError(){
        $repository = $this->createRepository();
        $entity = new EntityModel();
        $entity->setEntityData('name', 'Test Entity for add method');
        $entity->email_contact_recovery = 'some@email';

        $this->factory->method('create')->willReturn(new EntityModel());
        $this->database->method('queryParams')->willThrowException(new QueryExeption('some database error'));
        $this->expectException(CouldNotAddException::class);

        $repository->add($entity);
    }
}

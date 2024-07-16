<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\Entity\EntityRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\Sql\Entity\EntityFactory;
use Romchik38\Server\Models\Sql\Entity\EntityModel;
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
        $entityRow = [
            ['entity_id' => '1', 'name' => 'Company Site1']
        ];
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

}

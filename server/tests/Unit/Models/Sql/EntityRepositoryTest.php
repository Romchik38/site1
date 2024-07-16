<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\Entity\EntityRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\Sql\Entity\EntityFactory;
use Romchik38\Server\Models\Sql\Entity\EntityModel;


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

    public function testGetById()
    {
        $repository = $this->createRepository();
        $id = 1;
        $fieldNameEmail = 'email_contact_recovery';
        $fieldValueEmail = 'some@mail.com';
        $entityRow = ['entity_id' => '1', 'name' => 'Company Site1'];
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

        // $query = 'SELECT * FROM ' . $this->entityTable 
        //     . ' WHERE ' . $this->primaryEntityFieldName . ' = $1';

        // $queryFields = 'SELECT * FROM '
        //     . $this->fieldsTable . ' WHERE ' . $this->primaryEntityFieldName . ' = $1';

        $this->database->expects($this->exactly(2))->method('queryParams')
            ->willReturn([$entityRow], $fieldsRow);

        $entity = new EntityModel();
        $this->factory->method('create')->willReturn($entity);

        $result = $repository->getById($id);

        echo ($result->email_contact_recovery);
        var_dump($result->getFieldsData());
    }
}

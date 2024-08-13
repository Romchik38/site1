<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Server\Models\Errors\CouldNotAddException;
use Romchik38\Server\Models\Errors\CouldNotDeleteException;
use Romchik38\Server\Models\Errors\QueryExeption;
use Romchik38\Server\Models\Model;
use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\ModelFactory;

class RepositoryTest extends TestCase
{
    private $database;
    private $factory;
    protected string $table = 'table1';
    protected string $primaryFieldName = 'id';

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabasePostgresql::class);
        $this->factory = $this->createMock(ModelFactory::class);
    }

    protected function createRepository(): RepositoryInterface
    {
        return new Repository(
            $this->database,
            $this->factory,
            $this->table,
            $this->primaryFieldName
        );
    }

    /** 
     * method add
     * tests
     *   1 factory creation
     *   2 query
     *   3 entity
     *   4 entity data
     */
    public function testAdd()
    {
        $entity = new Model();
        $entity->setData('model_key1', 'model_value1');
        $entity->setData('model_key2', 'model_value2');
        $modelData = ['model_key1' => 'model_value1', 'model_key2' => 'model_value2'];
        $expectedQuery = 'INSERT INTO ' . $this->table
            . ' (model_key1, model_key2) VALUES ($1, $2) RETURNING *';

        $entityFromFactory = new Model();
        // 1 factory creation
        $this->factory->expects($this->once())->method('create')->willReturn($entityFromFactory);

        // 2 query and params
        $this->database->expects($this->once())->method('queryParams')
            ->willReturn([$modelData])
            ->with($this->callback(
                function ($query) use ($expectedQuery) {
                    if ($query !== $expectedQuery) {
                        return false;
                    }
                    return true;
                }
            ), ['model_value1', 'model_value2']);

        $repository = $this->createRepository();
        $addedEntity = $repository->add($entity);

        // 3 entity
        $this->assertSame($entityFromFactory, $addedEntity);

        // 4 entity data
        $this->assertSame('model_value1', $addedEntity->getData('model_key1'));
    }

    /**
     * method add 
     * throws CouldNotAddException
     */
    public function testAddThrowsError()
    {
        $this->database->method('queryParams')->willThrowException(new QueryExeption());

        $this->expectException(CouldNotAddException::class);

        $repository = $this->createRepository();
        $repository->add(new Model());
    }

    /** 
     * method create
     * tests:
     *   1 factory creation
     *   2 entity
     */
    public function testCreate()
    {
        // prepare data
        $entity = new Model();

        // 1 factory creation
        $this->factory->expects($this->once())->method('create')->willReturn($entity);

        $repository = $this->createRepository();
        $createdEntity = $repository->create();

        // 2 entity
        $this->assertSame($entity, $createdEntity);
    }

    /**
     * method deleteById
     * tests:
     *   1 query and params
     */
    public function testDeleteById()
    {
        $id = 1;
        $expectedQuery = 'DELETE FROM ' . $this->table . ' WHERE '
            . $this->primaryFieldName . ' = $1';

        // 1 query and params
        $this->database->expects($this->once())->method('queryParams')
            ->with($this->callback(
                function ($query) use ($expectedQuery) {
                    if ($query !== $expectedQuery) {
                        return false;
                    }
                    return true;
                }
            ), [$id]);

        $repository = $this->createRepository();
        $repository->deleteById($id);
    }

    /**
     * metyhod deleteById 
     * throws CouldNotDeleteException
     */
    public function testDeleteByIdThrowsError()
    {
        $this->database->method('queryParams')->willThrowException(new QueryExeption());

        $this->expectException(CouldNotDeleteException::class);
        $repository = $this->createRepository();
        $repository->deleteById(1);
    }

    
    // for list
    //$modelData2 = ['model2_key1' => 'model2_value1', 'model2_key2' => 'model2_value2'];

}

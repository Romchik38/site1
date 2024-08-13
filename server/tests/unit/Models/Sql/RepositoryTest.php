<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Server\Models\Errors\CouldNotAddException;
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
     *   0 factory creation
     *   1 query
     *   2 entity
     *   3 entity data
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
        // 0 factory creation
        $this->factory->expects($this->once())->method('create')->willReturn($entityFromFactory);

        // 1 query and params
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

        // 2 entity
        $this->assertSame($entityFromFactory, $addedEntity);

        // 3 entity data
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


    //$modelData2 = ['model2_key1' => 'model2_value1', 'model2_key2' => 'model2_value2'];

}

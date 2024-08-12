<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\CompositeId\CompositeIdRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\CompositeId\CompositeIdFactory;
use Romchik38\Server\Models\CompositeId\CompositeIdModel;
use Romchik38\Server\Models\CompositeId\CompositeIdDTOFactory;
use Romchik38\Server\Models\CompositeId\CompositeIdDTO;
use Romchik38\Server\Models\Errors\CouldNotAddException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\QueryExeption;

class CompositeIdRepositoryTest extends TestCase
{
    private $database;
    private $factory;
    private $idFactory;
    private string $table = 'composite_id_table';

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabasePostgresql::class);
        $this->factory = $this->createMock(CompositeIdFactory::class);
        $this->idFactory = $this->createMock(CompositeIdDTOFactory::class);
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

    /**
     * method create
     */
    public function testCreate()
    {

        $compositeIdEntity = new CompositeIdModel();

        $this->factory->expects($this->once())->method('create')
            ->willReturn($compositeIdEntity);

        $repository = $this->createRepository();
        $entity = $repository->create();

        $this->assertSame($compositeIdEntity, $entity);
    }

    /**
     * method getById
     * tested:
     *   1 query
     *   2 entity
     *   3 entity id
     *   4 entity data
     */
    public function testGetByIdQuery()
    {
        $idDTOData = ['dto_key' => 'dto_val'];
        $modelData = ['model_key' => 'model_value'];
        $allData = [...$idDTOData, ...$modelData];
        $idDTO = new CompositeIdDTO($idDTOData);
        $expectedQuery = 'SELECT ' . $this->table . '.* FROM ' . $this->table . ' WHERE '
            . 'dto_key = $1';

        $entity = new CompositeIdModel();

        $this->factory->method('create')->willReturn($entity);

        // 1 query and params
        $this->database->expects($this->once())->method('queryParams')
            ->willReturn([$allData])
            ->with($this->callback(
                function ($query) use ($expectedQuery) {
                    if ($query !== $expectedQuery) {
                        return false;
                    }
                    return true;
                }
            ), ['dto_val']);;

        $this->idFactory->expects($this->once())->method('create')
            ->with($allData)->willReturn($idDTO);



        $repository = $this->createRepository();
        $createdEntity = $repository->getById($idDTO);

        // 2 entity
        $this->assertSame($entity, $createdEntity);

        // 3 entity id
        $this->assertSame($idDTO, $createdEntity->getId());

        // 4 entity data
        $this->assertSame('model_value', $createdEntity->getData('model_key'));
    }

    /**
     * method getById
     * throws NoSuchEntityException
     */
    public function testGetByIdThrowError()
    {
        $idDTOData = ['dto_key' => 'dto_val'];
        $idDTO = new CompositeIdDTO($idDTOData);

        $this->database->method('queryParams')
            ->willReturn([]);

        $this->expectException(NoSuchEntityException::class);

        $repository = $this->createRepository();
        $repository->getById($idDTO);
    }

    /**
     * method add
     * tested:
     *   1 query
     */
    public function testAdd()
    {
        // prepare data
        $entity = new CompositeIdModel();
        $entity->setData('dto_key', 'dto_val');
        $entity->setData('model_key', 'model_value');
        $idDTOData = ['dto_key' => 'dto_val'];
        $modelData = ['model_key' => 'model_value'];
        $allData = [...$idDTOData, ...$modelData];
        $idDTO = new CompositeIdDTO($idDTOData);
        $expectedQuery = 'INSERT INTO ' . $this->table
            . ' (dto_key, model_key) VALUES ($1, $2) RETURNING *';

        $entityFromFactory = new CompositeIdModel();
        $this->factory->method('create')->willReturn($entityFromFactory);


        $this->idFactory->method('create')->willReturn($idDTO);

        // 1 query and params
        $this->database->expects($this->once())->method('queryParams')
            ->willReturn([$allData])
            ->with($this->callback(
                function ($query) use ($expectedQuery) {
                    if ($query !== $expectedQuery) {
                        return false;
                    }
                    return true;
                }
            ), ['dto_val', 'model_value']);;

        // exec
        $repository = $this->createRepository();
        $addedEntity = $repository->add($entity);

        // 2 entity
        $this->assertSame($entityFromFactory, $addedEntity);

        // 3 entity id
        $this->assertSame($idDTO, $addedEntity->getId());

        // 4 entity data
        $this->assertSame('model_value', $addedEntity->getData('model_key'));
    }

    /**
     * method add
     * throws CouldNotAddException
     */
    public function testAddThrowsError()
    {
        $this->database->method('queryParams')->willThrowException(new QueryExeption());

        $this->expectException(CouldNotAddException::class);

        // exec
        $repository = $this->createRepository();
        $repository->add(new CompositeIdModel());

    }
}

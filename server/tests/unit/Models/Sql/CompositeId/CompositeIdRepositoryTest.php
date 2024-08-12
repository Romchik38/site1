<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Models\Sql\CompositeId\CompositeIdRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Server\Models\CompositeId\CompositeIdFactory;
use Romchik38\Server\Models\CompositeId\CompositeIdModel;
use Romchik38\Server\Models\CompositeId\CompositeIdDTOFactory;
use Romchik38\Server\Models\CompositeId\CompositeIdDTO;

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
    public function testCreate() {
        
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
    public function testGetByIdQuery(){
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
                function($query) use ($expectedQuery){
                if ($query !== $expectedQuery) {
                    return false;
                    //$param[0] !== 'val2'
                }
                return true;
            }), ['dto_val']);;

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
}

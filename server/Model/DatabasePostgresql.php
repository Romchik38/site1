<?php

declare(strict_types=1);

namespace Romchik38\Server\Model;

use Romchik38\Server\Api\Model\DatabaseInterface;
use Romchik38\Server\Model\Errors\CreateConnectionExeption;
use Romchik38\Server\Model\Errors\QueryExeption;

class DatabasePostgresql implements DatabaseInterface
{
    private \PgSql\Connection|false $connection;

    public function __construct(string $config)
    {
        $this->connection = pg_connect($config);
        if ($this->connection === false) {
            throw new CreateConnectionExeption('Could\'t create connection');
        }
    }

    public function __destruct()
    {
        if ($this->connection) {
            pg_close($this->connection);
        }
    }

    public function queryParams(string $query, array $params): array {
        $result = pg_query_params($this->connection, $query, $params);
        if ($result === false) {
            $errMsg = pg_last_error($this->connection);
            throw new QueryExeption($errMsg);
        } 
        $arr = pg_fetch_all($result);
        pg_free_result($result);
        return $arr;
    }
}

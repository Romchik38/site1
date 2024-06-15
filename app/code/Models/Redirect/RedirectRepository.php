<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Redirect;

use Romchik38\Server\Models\Repository;
use Romchik38\Server\Api\Models\RedirectRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\RedirectModelInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;


class RedirectRepository extends Repository implements RedirectRepositoryInterface
{
    protected const URL_FIELD = 'url';
    protected const REDIRECT_FIELD = 'redirect_to';

    public function __construct(
        protected DatabaseInterface $database,
        protected ModelFactoryInterface $modelFactory,
        protected string $table,
        protected string $primaryFieldName
    ) {
    }

    public function checkUrl(string $url): RedirectModelInterface
    {
        $expression = 'WHERE ' . $this::URL_FIELD . ' = $1';
        $arr = $this->list($expression, [$url]);
        if (count($arr) === 0) {
            throw new NoSuchEntityException('There is no entity: ' . $url);
        } else {
            $redirect = $arr[0];
            return  $redirect;
        }
    }

    /**
     * Create an entity from provided row
     *   or
     * an empty entity if the row wasn't provided
     *
     * @param array $row [explicite description]
     *
     * @return ModelInterface
     */
    public function create(array $row = null): RedirectModelInterface
    {
        $entity = $this->modelFactory->create();
        if ($row !== null) {
            foreach ($row as $key => $value) {
                $entity->setData($key, $value);
            }
        }

        return $entity;
    }
}

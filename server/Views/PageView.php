<?php

declare(strict_types=1);

namespace Romchik38\Server\Views;

use \Romchik38\Server\Api\Views\ViewInterface;
use \Romchik38\Server\Api\Models\DTOInterface;

class PageView implements ViewInterface
{
    protected string $controllerData = '';
    protected array $metaData = [];

    public function __construct(
        protected $generateTemplate,
        protected $controllerTemplate
        )
    {
    }

    protected function prepareMetaData(): void{
        /** use this for add info to metaData */
    }

    public function setControllerData(DTOInterface $data): ViewInterface
    {
        $this->controllerData = call_user_func($this->controllerTemplate, $data);
        return $this;
    }

    public function setMetadata(string $key, string $value): ViewInterface
    {
        $this->metaData[$key] = $value;
        return $this;
    }

    public function toString(): string
    {
        return $this->build();
    }

    protected function build(): string
    {

        $this->prepareMetaData();

        $html = call_user_func(
            $this->generateTemplate,
            $this->metaData,
            $this->controllerData
        );

        return $html;
    }
}

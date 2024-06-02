<?php

declare(strict_types=1);

namespace Romchik38\Server\View;

use \Romchik38\Server\Api\View;

class PageView implements View
{
    protected string $controllerData = '';
    protected array $metaData = [];

    public function __construct(protected $generateTemplate)
    {
    }

    public function prepareMetaData(): void{
        /** use this for add info to metaData */
    }

    public function setControllerData(string $data): View
    {
        $this->controllerData = $data;
        return $this;
    }

    public function setMetadata(string $key, string $value): View
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

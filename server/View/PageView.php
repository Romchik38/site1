<?php

declare(strict_types=1);

namespace Romchik38\Server\View;

use \Romchik38\Server\Api\View;

class PageView implements View
{
    protected string $controllerData = '';
    protected array $metaData = [];

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
        $doctype = '<!DOCTYPE html>';
        $htmlStart = '<html lang="en">';
        $head = '<head>'
            . '<meta charset="UTF-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
            . '<title>' . $this->metaData[$this::TITLE] . '</title>'
            . '</head>';
        $bodyStart = '<body>';
        $bodyEnd = '</body>';
        $htmlEnd = '</html>';

        return $doctype
            . $htmlStart
            . $head
            . $bodyStart
            . $this->controllerData
            . $bodyEnd
            . $htmlEnd;
    }
}

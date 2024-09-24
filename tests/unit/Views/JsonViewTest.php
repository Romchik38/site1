<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Views\JsonView;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

class JsonViewTest extends TestCase
{
    public function testToString()
    {
        $name = 'some name';
        $description = 'some description';

        $dto = new DefaultViewDTO($name, $description);
        $jsonView = new JsonView();
        $jsonView->setControllerData($dto);
        $result = $jsonView->toString();

        $this->assertSame(json_encode($dto->getAllData()), $result);
    }
}

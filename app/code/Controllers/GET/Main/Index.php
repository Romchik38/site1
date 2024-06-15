<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\GET\Main;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Results\ControllerResultInterface;
use Romchik38\Site1\Views\Main\Index as View;
use Romchik38\Site1\Models\Page\PageRepository;

class Index implements ControllerInterface
{
    public function __construct(
        protected ControllerResultInterface $controllerResult,
        protected View $view,
        protected PageRepository $pageRepository
    ) {
    }
    public function execute($action): ControllerResultInterface
    {
        if ($action === '') {
            $action = 'index';
        }

        $arr = $this->pageRepository->list(' WHERE url = $1', [$action]);

        if (count($arr) === 0) {
            $this->controllerResult->setResponse('From main controller - 404 Error page not found');
            $this->controllerResult->setStatusCode(404);
        } else {
            $page = $arr[0];
            $this->view
                ->setMetadata(View::TITLE, $page->getData('name'))
                ->setControllerData($page->getData('content'));
            $this->controllerResult->setResponse($this->view->toString());
        }

        return $this->controllerResult;
    }
}

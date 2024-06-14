<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\GET\Main;

use Romchik38\Server\Api\Controller;
use Romchik38\Server\Api\ControllerResult;
use Romchik38\Site1\Views\Main\Index as View;
use Romchik38\Site1\Models\PageRepository;

class Index implements Controller
{
    public function __construct(
        protected ControllerResult $controllerResult,
        protected View $view,
        protected PageRepository $pageRepository
    ) {
    }
    public function execute(): ControllerResult
    {
        [$url] = explode('?', $_SERVER['REQUEST_URI']);
        $baseName = pathinfo($url)['basename'];


        if ($baseName === '') {
            $baseName = 'index';
        }

        $arr = $this->pageRepository->list(' WHERE url = $1', [$baseName]);

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

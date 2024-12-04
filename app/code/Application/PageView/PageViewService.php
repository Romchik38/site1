<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\PageView;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Application\PageView\Views\NameUrl;
use Romchik38\Site1\Domain\Page\PageRepositoryInterface;
use Romchik38\Site1\Domain\Page\VO\Name;
use Romchik38\Site1\Domain\Page\VO\Url;

final class PageViewService
{
    public function __construct(
        protected readonly PageRepositoryInterface $pageRepository
    ) {}

    /** @return array<int,NameUrl> */
    public function listAllUrlsAndNames(): array
    {
        $dtos = [];
        $pages = $this->pageRepository->listAll();
        foreach ($pages as $page) {
            $name = new Name($page->getName());
            $url = new Url($page->getUrl());
            $dtos[] = new NameUrl(
                $name(),
                $url()
            );
        }
        return $dtos;
    }

    /** 
     * @throws InvalidArgumentException
     * @throws CantFindException 
     * */
    public function searchNameByUrl(FindByUrl $command): Name
    {
        $url = new Url($command->url);

        try {
            $page = $this->pageRepository->getByUrl($url());
            return new Name($page->getName());
        } catch (NoSuchEntityException) {
            throw new CantFindException(sprintf('page url %s not exist', $url()));
        }
    }
}

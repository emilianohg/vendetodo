<?php

namespace App\Domain\Common;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ReflectionClass;

class Pagination {

    public function __construct(
        private int $total,
        private int $per_page,
        private int $current_page,
        private int $last_page,
        private string $first_page_url,
        private string $last_page_url,
        private string $path,
        private array $data,
        private ?string $from = null,
        private ?string $to = null,
        private ?string $next_page_url = null,
        private ?string $prev_page_url = null
    )
    {}

    /**
     * @template T
     * @param LengthAwarePaginator $paginator
     * @param class-string<T> $className
     * @return T
     */
    public static function fromPaginator(LengthAwarePaginator $paginator, string $className): Pagination
    {
        $items = [];
        foreach ($paginator->items() as $item) {
            $attributeClass = new ReflectionClass($className);
            $instance = $attributeClass->newInstanceWithoutConstructor();
            $items[] = $instance->from($item->toArray());
        }

        return new Pagination(
            total: $paginator->total(),
            per_page: $paginator->perPage(),
            current_page: $paginator->currentPage(),
            last_page: $paginator->lastPage(),
            first_page_url: $paginator->url(1),
            last_page_url: $paginator->url($paginator->lastPage()),
            path: $paginator->path(),
            data: $items,
            from: $paginator->firstItem(),
            to: $paginator->lastItem(),
            next_page_url: $paginator->nextPageUrl(),
            prev_page_url: $paginator->previousPageUrl(),
        );
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPerPage(): int
    {
        return $this->per_page;
    }

    public function getCurrentPage(): int
    {
        return $this->current_page;
    }

    public function getLastPage(): int
    {
        return $this->last_page;
    }

    public function getFirstPageUrl(): string
    {
        return $this->first_page_url;
    }

    public function getLastPageUrl(): string
    {
        return $this->last_page_url;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function getNextPageUrl(): ?string
    {
        return $this->next_page_url;
    }

    public function getPrevPageUrl(): ?string
    {
        return $this->prev_page_url;
    }

    public function getLeftBound(): int
    {
        return max(1, min($this->getCurrentPage() - 4, $this->getCurrentPage() - 2));
    }

    public function getRightBound(): int
    {
        return min($this->getLastPage(), max($this->getCurrentPage() + 2, 5));
    }

}
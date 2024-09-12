<?php declare(strict_types=1);

namespace App\Paginator;

class Paginator
{
    public function __construct(
        private readonly int $itemsPerPage,
        private readonly int $totalItems,
        private readonly int $currentPage
    )
    {
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return bool
     */
    public function shopPagination(): bool
    {
        return $this->getTotalPages() > 1;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return (int)ceil($this->totalItems / $this->itemsPerPage);
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    /**
     * @return bool
     */
    public function showNextButton(): bool
    {
        return $this->currentPage < $this->getTotalPages();
    }

    /**
     * @return int
     */
    public function getNextPage(): int
    {
        return $this->currentPage + 1;
    }

    /**
     * @return bool
     */
    public function showPreviousButton(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * @return int
     */
    public function getPreviousPage(): int
    {
        return $this->currentPage - 1;
    }
}
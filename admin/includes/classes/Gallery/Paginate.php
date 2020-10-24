<?php


namespace Gallery;


class Paginate
{
    public $currentPage;
    public $itemsPerPage;
    public $itemsTotalCount;

    /**
     * Paginate constructor.
     * @param int $page
     * @param int $items_per_page
     * @param int $items_total_count
     */
    public function __construct($page = 1, $items_per_page = 4, $items_total_count = 0)
    {
        $this->currentPage = (int) $page;
        $this->itemsPerPage = (int) $items_per_page;
        $this->itemsTotalCount = (int) $items_total_count;
    }

    /**
     * @return int
     */
    public function next() {
        return $this->currentPage + 1;
    }

    /**
     * @return int
     */
    public function previous() {
        return $this->currentPage - 1;
    }

    /**
     * @return false|float
     */
     public function totalPages() {
        return ceil(($this->itemsTotalCount/$this->itemsPerPage));
     }

    /**
     * @return bool
     */
     public function hasPreviousPage() {
        return (bool) ($this->previous() >= 1);
     }

    /**
     * @return bool
     */
    public function hasNextPage() {
        return (bool) ($this->next() <= $this->totalPages());
    }

    /**
     * @return float|int
     */
    public function offset() {
        return (($this->currentPage - 1) * $this->itemsPerPage);
    }
}
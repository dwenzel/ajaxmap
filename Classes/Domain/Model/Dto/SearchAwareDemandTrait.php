<?php

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

/**
 * Class SearchAwareDemandTrait
 * Provides properties and methods for (full-text) search aware demand objects
 */
trait SearchAwareDemandTrait
{
    /**
     * @var Search
     */
    protected $search;

    /**
     * Get search
     *
     * @return Search
     */
    public function getSearch(): Search
    {
        if (null === $this->search) {
            $this->search = new NullSearch();
        }
        return $this->search;
    }

    /**
     * Set search object
     *
     * @param Search $search A search object
     * @return void
     */
    public function setSearch(Search $search): void
    {
        $this->search = $search;
    }
}

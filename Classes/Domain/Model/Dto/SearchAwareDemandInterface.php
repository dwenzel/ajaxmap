<?php

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

/**
 * Interface SearchAwareDemandInterface
 *
 */
interface SearchAwareDemandInterface
{
    /**
     * Get search
     *
     * @return Search
     */
    public function getSearch(): Search;

    /**
     * Set search object
     *
     * @param Search $search A search object
     * @return void
     */
    public function setSearch(Search $search): void;
}

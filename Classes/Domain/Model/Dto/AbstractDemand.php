<?php

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

use CPSIT\GeoLocationService\Service\GeoCoder;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Abstract Demand object which holds all common demand properties.
 */
class AbstractDemand implements DemandInterface, OrderAwareDemandInterface, SearchAwareDemandInterface
{
    use OrderAwareDemandTrait, SearchAwareDemandTrait;
    /**
     * Uid list
     *
     * @var string
     */
    protected $uidList;

    /**
     * Hidden
     *
     * @var boolean
     */
    protected $hidden;

    /**
     * @var Search
     */
    protected $search;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var string
     */
    protected $orderByAllowed;

    /**
     * @var string
     */
    protected $storagePages;

    /**
     * @var integer
     */
    protected $limit;

    /**
     * Orderings
     *
     * @var array
     */
    protected $orderings;

    /**
     * @var integer
     */
    protected $offset;

    /**
     * @var array
     */
    protected $geoLocation;

    /**
     * @var integer
     */
    protected $radius;


    /**
     * Get a list of unique ids
     *
     * @return string
     */
    public function getUidList()
    {
        return $this->uidList;
    }

    /**
     * Sets a list of unique ids
     * @param string $uidList
     */
    public function setUidList($uidList)
    {
        $this->uidList = $uidList;
    }

    /**
     * Returns the hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Get allowed order fields
     *
     * @return string
     */
    public function getOrderByAllowed()
    {
        return $this->orderByAllowed;
    }

    /**
     * Set order allowed
     *
     * @param string $orderByAllowed allowed fields for ordering
     * @return void
     */
    public function setOrderByAllowed($orderByAllowed)
    {
        $this->orderByAllowed = $orderByAllowed;
    }

    /**
     * Get list of storage pages
     *
     * @return string
     */
    public function getStoragePages()
    {
        return $this->storagePages;
    }

    /**
     * Set list of storage pages
     *
     * @param string $storagePages storage page list
     * @return void
     */
    public function setStoragePages($storagePages)
    {
        $this->storagePages = $storagePages;
    }

    /**
     * Get limit
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set limit
     *
     * @param integer $limit limit
     * @return void
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * Returns the orderings
     *
     * @return string
     */
    public function getOrderings()
    {
        return $this->orderings;
    }

    /**
     * Sets the orderings
     *
     * @param array $orderings
     * @return array
     */
    public function setOrderings(array $orderings)
    {
        $this->orderings = $orderings;
    }

    /**
     * Get offset
     *
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set offset
     *
     * @param integer $offset offset
     * @return void
     */
    public function setOffset($offset)
    {
        $this->offset = (int)$offset;
    }

    /**
     * Get geo location
     *
     * @return array
     */
    public function getGeoLocation()
    {
        if ($this->geoLocation === null &&
            $this->search instanceof Search
            && !empty($this->search->getLocation())) {
            $geoCoder = new GeoCoder();
            $this->geoLocation = $geoCoder->getLocation($this->search->getLocation());
        }

        return $this->geoLocation;
    }

    /**
     * Set geo location
     *
     * @param array $geoLocation Geo location: center around which to search for
     * @return void
     */
    public function setGeoLocation($geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    /**
     * Get radius
     *
     * @return integer
     */
    public function getRadius()
    {
        if ($this->search instanceof Search
            && !empty($this->search->getRadius())) {
            $this->radius = $this->search->getRadius();
        }
        return $this->radius;
    }

    /**
     * Set radius
     *
     * @param integer $radius
     * @return void
     */
    public function setRadius($radius)
    {
        $this->radius = (int)$radius;
    }

}



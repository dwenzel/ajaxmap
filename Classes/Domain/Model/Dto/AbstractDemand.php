<?php
namespace Webfox\Ajaxmap\Domain\Model\Dto;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 <wenzel@webfox01.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/**
 * Abstract Demand object which holds all common demand properties.
 *
 * @package ajaxmap
 */
class AbstractDemand extends AbstractEntity implements DemandInterface {
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
	 * @var \Webfox\Ajaxmap\Domain\Model\Dto\Search
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
	public function getUidList() {
		return $this->uidList;
	}

	/**
	 * Sets a list of unique ids
	 * @param string $uidList
	 */
	public function setUidList($uidList) {
		$this->uidList = $uidList;
	}

	/**
	 * Returns the hidden
	 *
	 * @return boolean
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets the hidden
	 *
	 * @param boolean $hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Set search object
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Dto\Search $search A search object
	 * @return void
	 */
	public function setSearch($search) {
		$this->search = $search;
	}

	/**
	 * Get search 
	 *
	 * @return \Webfox\Ajaxmap\Domain\Model\Dto\Search
	 */
	public function getSearch() {
		return $this->search;
	}

	/**
	 * Set order
	 *
	 * @param string $order
	 * @return void
	 * @deprecated Use setOrderings instead
	 */
	public function setOrder($order) {
		$this->order = $order;
	}

	/**
	 * Get order
	 *
	 * @return string
	 * @deprecated Use getOrderings instead
	 */
	public function getOrder() {
		return $this->order;
	}

	/**
	 * Set order allowed
	 *
	 * @param string $orderByAllowed allowed fields for ordering
	 * @return void
	 */
	public function setOrderByAllowed($orderByAllowed) {
		$this->orderByAllowed = $orderByAllowed;
	}

	/**
	 * Get allowed order fields
	 *
	 * @return string
	 */
	public function getOrderByAllowed() {
		return $this->orderByAllowed;
	}

	/**
	 * Set list of storage pages
	 *
	 * @param string $storagePages storage page list
	 * @return void
	 */
	public function setStoragePages($storagePages) {
		$this->storagePages = $storagePages;
	}

	/**
	 * Get list of storage pages
	 *
	 * @return string
	 */
	public function getStoragePages() {
		return $this->storagePages;
	}

	/**
	 * Set limit
	 *
	 * @param integer $limit limit
	 * @return void
	 */
	public function setLimit($limit) {
		$this->limit = (int)$limit;
	}

	/**
	 * Get limit
	 *
	 * @return integer
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Returns the orderings
	 *
	 * @return string
	 */
	public function getOrderings() {
		return $this->orderings;
	}

	/**
	 * Sets the orderings
	 *
	 * @param array $orderings
	 * @return array
	 */
	public function setOrderings(array $orderings) {
		$this->orderings = $orderings;
	}

	/**
	 * Set offset
	 *
	 * @param integer $offset offset
	 * @return void
	 */
	public function setOffset($offset) {
		$this->offset = (int)$offset;
	}

	/**
	 * Get offset
	 *
	 * @return integer
	 */
	public function getOffset() {
		return $this->offset;
	}

	/**
	 * Set geo location
	 *
	 * @param array $geoLocation Geo location: center around which to search for
	 * @return void
	 */
	public function setGeoLocation($geoLocation) {
		$this->geoLocation = $geoLocation;
	}

	/**
	 * Get geo location
	 *
	 * @return array
	 */
	public function getGeoLocation() {
		return $this->geoLocation;
	}

	/**
	 * Set radius
	 *
	 * @param integer $radius
	 * @return void
	 */
	public function setRadius($radius) {
		$this->radius = (int)$radius;
	}

	/**
	 * Get radius
	 *
	 * @return integer
	 */
	public function getRadius() {
		return $this->radius;
	}

}



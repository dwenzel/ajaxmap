<?php
namespace Webfox\Ajaxmap\Domain\Model\Dto;

/***************************************************************
 *  Copyright notice
 *  (c) 2013 Dirk Wenzel <wenzel@webfox01.de>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Search object for searching text in fields
 *
 * @package placements
 */
class Search extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Basic search word
	 *
	 * @var \string
	 */
	protected $subject;

	/**
	 * Search fields
	 *
	 * @var \string
	 */
	protected $fields;

	/**
	 * Search location
	 *
	 * @var \string
	 */
	protected $location;

	/**
	 * Search radius
	 *
	 * @var \integer
	 */
	protected $radius;

	/**
	 * Bounding box
	 * 
	 * @var \array
	 */
	protected $bounds;

	/**
	 * Get the subject
	 *
	 * @return \string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Set subject
	 *
	 * @param \string $subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Get fields
	 *
	 * @return \string A comma separated list of search fields
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Set fields
	 *
	 * @param $fields A comma separated list of search fields
	 * @return void
	 */
	public function setFields($fields) {
		$this->fields = $fields;
	}

	/**
	 * Get location
	 *
	 * @return \string A string describing a location 
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Set location
	 *
	 * @param $location A string describing a location
	 * @return void
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * Get radius
	 *
	 * @return \integer The search radius in meter around the search location 
	 */
	public function getRadius() {
		return $this->radius;
	}

	/**
	 * Set radius
	 *
	 * @param \integer $radius The search radius in meter
	 * @return void
	 */
	public function setRadius($radius) {
		$this->radius = $radius;
	}

	/**
	 * Get Bounds
	 * @return \array An array describing a bounding box around a geolocation
	 */
	public function getBounds() {
		return $this->bounds;
	}
	
	/**
	 * Set Bounds
	 * @param \array $bounds
	 * @return void
	 */
	public function setBounds($bounds) {
		$this->bounds = $bounds;
	}
}

?>

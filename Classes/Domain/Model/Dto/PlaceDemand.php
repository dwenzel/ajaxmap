<?php
namespace DWenzel\Ajaxmap\Domain\Model\Dto;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 <wenzel@webfox01.de>
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

/**
 * Place Demand object which holds all information to get the correct
 * Place records.
 *
 * @package ajaxmap
 */
class PlaceDemand
	extends AbstractDemand
	implements DemandInterface, CategoryAwareDemandInterface {
	use CategoryAwareDemandTrait;

	/**
	* @var string
	*/
	protected $locationTypes;

	/**
	 * @var string
	 */
	protected $constraintsConjunction;

	/**
	 * @var string
	 */
	protected $placeGroups;

	/**
	 * @var string
	 */
	protected $placeGroupConjunction;

	/**
	 * @var int
	 */
	protected $map;

	/**
	 * Get LocationTypes
	 * @return string
	 */
	public function getLocationTypes () {
	    return $this->locationTypes;
	}

	/**
	 * Set LocationTypes
	 * @param string $locationTypes A comma separated list of location type uids
	 */
	public function setLocationTypes ($locationTypes) {
	    $this->locationTypes = $locationTypes;
	}

	/**
	 * Get Constraints Conjunction
	 * @return string
	 */
	public function getConstraintsConjunction () {
		return $this->constraintsConjunction;
	}

	/**
	 * Set Constraints Conjunction
	 *
	 * @param string $conjunction
	 */
	public function setConstraintsConjunction ($conjunction) {
		$this->constraintsConjunction = $conjunction;
	}

	/**
	 * Gets the place groups
	 * @return string
	 */
	public function getPlaceGroups () {
		return $this->placeGroups;
	}

	/**
	 * Sets the place groups
	 *
	 * @param string $placeGroups A comma separated list of placeGroups uids
	 */
	public function setPlaceGroups($placeGroups) {
		$this->placeGroups = $placeGroups;
	}

	/**
	 * Get PlaceGroup conjunction
	 * @return string
	 */
	public function getPlaceGroupConjunction () {
		return $this->placeGroupConjunction;
	}

	/**
	 * Set PlaceGroup conjunction
	 *
	 * @param string $conjunction
	 */
	public function setPlaceGroupConjunction ($conjunction) {
		$this->placeGroupConjunction = $conjunction;
	}

	/**
	 * Get Map
	 * @return int
	 */
	public function getMap () {
		return $this->map;
	}

	/**
	 * Set Map
	 *
	 * @param int $map
	 */
	public function setMap ($map) {
		$this->map = $map;
	}
}



<?php

namespace Webfox\Ajaxmap\Domain\Model;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
use Webfox\Ajaxmap\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Region extends AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Select KML files
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * clickable
	 *
	 * @var boolean
	 */
	protected $clickable = FALSE;

	/**
	 * suppressInfoWindows
	 *
	 * @var boolean
	 */
	protected $suppressInfoWindows = FALSE;

	/**
	 * preserveViewport
	 *
	 * @var boolean
	 */
	protected $preserveViewport = FALSE;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\Ajaxmap\Domain\Model\Region>
	 * @lazy
	 */
	protected $regions;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->regions = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the file
	 *
	 * @return string $file
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Sets the file
	 *
	 * @param string $file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = $file;
	}

	/**
	 * Returns the clickable
	 *
	 * @return boolean $clickable
	 */
	public function getClickable() {
		return $this->clickable;
	}

	/**
	 * Sets the clickable
	 *
	 * @param boolean $clickable
	 * @return void
	 */
	public function setClickable($clickable) {
		$this->clickable = $clickable;
	}

	/**
	 * Returns the boolean state of clickable
	 *
	 * @return boolean
	 */
	public function isClickable() {
		return $this->getClickable();
	}

	/**
	 * Returns the suppressInfoWindows
	 *
	 * @return boolean $suppressInfoWindows
	 */
	public function getSuppressInfoWindows() {
		return $this->suppressInfoWindows;
	}

	/**
	 * Sets the suppressInfoWindows
	 *
	 * @param boolean $suppressInfoWindows
	 * @return void
	 */
	public function setSuppressInfoWindows($suppressInfoWindows) {
		$this->suppressInfoWindows = $suppressInfoWindows;
	}

	/**
	 * Returns the boolean state of suppressInfoWindows
	 *
	 * @return boolean
	 */
	public function isSuppressInfoWindows() {
		return $this->getSuppressInfoWindows();
	}

	/**
	 * Returns the preserveViewport
	 *
	 * @return boolean $preserveViewport
	 */
	public function getPreserveViewport() {
		return $this->preserveViewport;
	}

	/**
	 * Sets the preserveViewport
	 *
	 * @param boolean $preserveViewport
	 * @return void
	 */
	public function setPreserveViewport($preserveViewport) {
		$this->preserveViewport = $preserveViewport;
	}

	/**
	 * Returns the boolean state of preserveViewport
	 *
	 * @return boolean
	 */
	public function isPreserveViewport() {
		return $this->getPreserveViewport();
	}

	/**
	 * Removes a Region
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Region $regionToRemove The Region to be removed
	 * @return void
	 */
	public function removeRegion(Region $regionToRemove) {
		$this->regions->detach($regionToRemove);
	}

	/**
	 * Returns the regions
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\Ajaxmap\Domain\Model\Region> $regions
	 */
	public function getRegions() {
		return $this->regions;
	}

	/**
	 * Sets the regions
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\Ajaxmap\Domain\Model\Region> $regions
	 * @return void
	 */
	public function setRegions(ObjectStorage $regions) {
		$this->regions = $regions;
	}

	/**
	 * Adds a Region
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Region $region
	 * @return void
	 */
	public function addRegion(Region $region) {
		$this->regions->attach($region);
	}
}


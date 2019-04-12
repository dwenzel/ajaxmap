<?php

namespace DWenzel\Ajaxmap\Domain\Model;
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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\Ajaxmap\DomainObject\CategorizableInterface;
use DWenzel\Ajaxmap\DomainObject\SerializableInterface;

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Place extends AbstractEntity
	implements SerializableInterface, CategorizableInterface {
	use ToArrayTrait, ToJsonTrait, CategorizableTrait;
	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Enter  geo coordinates (latitude,longitude - 10.99999,51.8888)
	 *
	 * @var string
	 */
	protected $geoCoordinates;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Additional info. Can be shown in info window.
	 *
	 * @var string
	 */
	protected $info;

	/**
	 * Place Groups
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup>
	 */
	protected $placeGroups;

	/**
	 * Location Type
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Model\LocationType
	 */
	protected $locationType;

	/**
	 * regions
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region>
	 */
	protected $regions;

	/**
	 * Add content.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Content>
	 */
	protected $content;

	/**
	 * Add address
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Model\Address
	 */
	protected $address;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->categories = new ObjectStorage();
		$this->placeGroups = new ObjectStorage();
		$this->regions = new ObjectStorage();
		$this->content = new ObjectStorage();
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
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Adds a PlaceGroup
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup
	 * @return void
	 */
	public function addPlaceGroup(PlaceGroup $placeGroup) {
		$this->placeGroups->attach($placeGroup);
	}

	/**
	 * Removes a PlaceGroup
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup The PlaceGroup to be removed
	 * @return void
	 */
	public function removePlaceGroup(PlaceGroup $placeGroup) {
		$this->placeGroups->detach($placeGroup);
	}

	/**
	 * Returns the placeGroups
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> $placeGroups
	 */
	public function getPlaceGroups() {
		return $this->placeGroups;
	}

	/**
	 * Sets the placeGroups
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> $placeGroups
	 * @return void
	 */
	public function setPlaceGroups(ObjectStorage $placeGroups) {
		$this->placeGroups = $placeGroups;
	}

	/**
	 * Returns the Location Type
	 *
	 * @return \DWenzel\Ajaxmap\Domain\Model\LocationType
	 */
	public function getLocationType() {
		return $this->locationType;
	}

	/**
	 * Sets the Location Type
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\LocationType $locationType
	 * @return void
	 */
	public function setLocationType(LocationType $locationType) {
		$this->locationType = $locationType;
	}

	/**
	 * Adds a Region
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Region $region
	 * @return void
	 */
	public function addRegion(Region $region) {
		$this->regions->attach($region);
	}

	/**
	 * Removes a Region
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Region $regionToRemove The Region to be removed
	 * @return void
	 */
	public function removeRegion(Region $regionToRemove) {
		$this->regions->detach($regionToRemove);
	}

	/**
	 * Returns the regions
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region> $regions
	 */
	public function getRegions() {
		return $this->regions;
	}

	/**
	 * Sets the regions
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region> $regions
	 * @return void
	 */
	public function setRegions(ObjectStorage $regions) {
		$this->regions = $regions;
	}

	/**
	 * Returns the info
	 *
	 * @return string $info
	 */
	public function getInfo() {
		return $this->info;
	}

	/**
	 * Sets the info
	 *
	 * @param string $info
	 * @return void
	 */
	public function setInfo($info) {
		$this->info = $info;
	}

	/**
	 * Adds a content element
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Content $content
	 */
	public function addContent(Content $content) {
		$this->content->attach($content);
	}

	/**
	 * Removes a content element
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Content $contentToRemove The Content to be removed
	 */
	public function removeContent(Content $contentToRemove) {
		$this->content->detach($contentToRemove);
	}

	/**
	 * Returns the content
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Content> content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the content
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Content> $content
	 */
	public function setContent(ObjectStorage $content) {
		$this->content = $content;
	}

	/**
	 * Returns the address
	 *
	 * @return \DWenzel\Ajaxmap\Domain\Model\Address $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Address $address
	 * @return void
	 */
	public function setAddress(Address $address) {
		$this->address = $address;
	}

	/**
	 * Returns the geoCoordinates
	 *
	 * @return string geoCoordinates
	 */
	public function getGeoCoordinates() {
		return $this->geoCoordinates;
	}

	/**
	 * Sets the geoCoordinates
	 *
	 * @param string $geoCoordinates
	 * @return string geoCoordinates
	 */
	public function setGeoCoordinates($geoCoordinates) {
		$this->geoCoordinates = $geoCoordinates;
	}
}

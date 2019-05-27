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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DWenzel\Ajaxmap\DomainObject\CategorizableInterface;
use DWenzel\Ajaxmap\DomainObject\SerializableInterface;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Map extends AbstractEntity
	implements SerializableInterface, CategorizableInterface {
	use ToArrayTrait, ToJsonTrait, CategorizableTrait;

	/**
	 * title
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $title;

	/**
	 * type
	 *
	 * @var integer
	 */
	protected $type;

	/**
	 * width
	 *
	 * @var integer
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $width;

	/**
	 * height
	 *
	 * @var integer
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $height;

	/**
	 * Center of Map (Geo location: latitude, longitude - 10.999999,51.777777)
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $mapCenter;

	/**
	 * initialZoom
	 *
	 * @var integer
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $initialZoom;

	/**
	 * optional Style (json Array)
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $mapStyle;

	/**
	 * disable default UI
	 *
	 * @var boolean
	 */
	protected $disableDefaultUi = false;

	/**
	 * Select items for display by category.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Category>
	 */
	protected $categories;

	/**
	 * Select items for display by placeGroups.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup>
	 */
	protected $placeGroups;

	/**
	 * regions
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region>
	 */
	protected $regions;

	/**
	 * Static layers
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region>
	 */
	protected $staticLayers;

	/**
	 * Display selected places as markers.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Place>
	 */
	protected $places;

	/**
	 * Selected places by location type.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\LocationType>
	 */
	protected $locationTypes;

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
	 * Returns the width
	 *
	 * @return integer $width
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * Sets the width
	 *
	 * @param integer $width
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * Returns the height
	 *
	 * @return integer height
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * Sets the height
	 *
	 * @param integer $height
	 * @return integer height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * __construct
	 *
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
		$this->categories = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$this->placeGroups = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$this->regions = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$this->staticLayers = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$this->places = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
		$this->locationTypes = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
	}

	/**
	 * Adds a Region
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Region $region
	 * @return void
	 */
	public function addRegion(\DWenzel\Ajaxmap\Domain\Model\Region $region) {
		$this->regions->attach($region);
	}

	/**
	 * Removes a Region
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Region $regionToRemove The Region to be removed
	 * @return void
	 */
	public function removeRegion(\DWenzel\Ajaxmap\Domain\Model\Region $regionToRemove) {
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
	public function setRegions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $regions) {
		$this->regions = $regions;
	}

	/**
	 * Adds a Static Layer
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Region $staticLayer
	 * @return void
	 */
	public function addStaticLayer(\DWenzel\Ajaxmap\Domain\Model\Region $staticLayer) {
		$this->staticLayers->attach($staticLayer);
	}

	/**
	 * Removes a Static Layer
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Region $staticLayerToRemove The Region to be removed
	 * @return void
	 */
	public function removeStaticLayer(\DWenzel\Ajaxmap\Domain\Model\Region $staticLayerToRemove) {
		$this->staticLayers->detach($staticLayerToRemove);
	}

	/**
	 * Returns the static Layers
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region> $staticLayers
	 */
	public function getStaticLayers() {
		return $this->staticLayers;
	}

	/**
	 * Sets the staticLayers
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region> $staticLayers
	 * @return void
	 */
	public function setStaticLayers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $staticLayers) {
		$this->staticLayers = $staticLayers;
	}

	/**
	 * Returns the type
	 *
	 * @return integer $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param integer $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the mapStyle
	 *
	 * @return string $mapStyle
	 */
	public function getMapStyle() {
		return $this->mapStyle;
	}

	/**
	 * Sets the mapStyle
	 *
	 * @param string $mapStyle
	 * @return void
	 */
	public function setMapStyle($mapStyle) {
		$this->mapStyle = preg_replace('/(?:\s\s+|\n|\t)/', '', $mapStyle);
	}

	/**
	 * Returns the initialZoom
	 *
	 * @return integer $initialZoom
	 */
	public function getInitialZoom() {
		return $this->initialZoom;
	}

	/**
	 * Sets the initialZoom
	 *
	 * @param integer $initialZoom
	 * @return void
	 */
	public function setInitialZoom($initialZoom) {
		$this->initialZoom = $initialZoom;
	}

	/**
	 * Returns the disableDefaultUi
	 *
	 * @return boolean disableDefaultUi
	 */
	public function getDisableDefaultUi() {
		return $this->disableDefaultUi;
	}

	/**
	 * Sets the disableDefaultUi
	 *
	 * @param boolean $disableDefaultUi
	 * @return boolean disableDefaultUi
	 */
	public function setDisableDefaultUi($disableDefaultUi) {
		$this->disableDefaultUi = $disableDefaultUi;
	}

	/**
	 * Returns the boolean state of disableDefaultUi
	 *
	 * @return boolean disableDefaultUi
	 */
	public function isDisableDefaultUi() {
		return $this->getDisableDefaultUI();
	}

	/**
	 * Returns the mapCenter
	 *
	 * @return string mapCenter
	 */
	public function getMapCenter() {
		return $this->mapCenter;
	}

	/**
	 * Sets the mapCenter
	 *
	 * @param string $mapCenter
	 * @return string mapCenter
	 */
	public function setMapCenter($mapCenter) {
		$this->mapCenter = $mapCenter;
	}

	/**
	 * Adds a PlaceGroup
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> placeGroups
	 */
	public function addPlaceGroup(\DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup) {
		$this->placeGroups->attach($placeGroup);
	}

	/**
	 * Removes a PlaceGroup
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup The PlaceGroup to be removed
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> placeGroups
	 */
	public function removePlaceGroup(\DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup) {
		$this->placeGroups->detach($placeGroup);
	}

	/**
	 * Returns the placeGroups
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> placeGroups
	 */
	public function getPlaceGroups() {
		return $this->placeGroups;
	}

	/**
	 * Sets the placeGroups
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> $placeGroups
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup> placeGroups
	 */
	public function setPlaceGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $placeGroups) {
		$this->placeGroups = $placeGroups;
	}

	/**
	 * Adds a Place
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Place $place
	 * @return void
	 */
	public function addPlace(\DWenzel\Ajaxmap\Domain\Model\Place $place) {
		$this->places->attach($place);
	}

	/**
	 * Removes a Place
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\Place $placeToRemove The Place to be removed
	 * @return void
	 */
	public function removePlace(\DWenzel\Ajaxmap\Domain\Model\Place $placeToRemove) {
		$this->places->detach($placeToRemove);
	}

	/**
	 * Returns the places
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Place> $places
	 */
	public function getPlaces() {
		return $this->places;
	}

	/**
	 * Sets the places
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Place> $places
	 * @return void
	 */
	public function setPlaces(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $places) {
		$this->places = $places;
	}

	/**
	 * Adds a LocationType
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\LocationType $locationType
	 * @return void
	 */
	public function addLocationType(\DWenzel\Ajaxmap\Domain\Model\LocationType $locationType) {
		$this->locationTypes->attach($locationType);
	}

	/**
	 * Removes a LocationType
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\LocationType $locationTypeToRemove The LocationType to be removed
	 * @return void
	 */
	public function removeLocationType(\DWenzel\Ajaxmap\Domain\Model\LocationType $locationTypeToRemove) {
		$this->locationTypes->detach($locationTypeToRemove);
	}

	/**
	 * Returns the locationTypes
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\LocationType> $locationTypes
	 */
	public function getLocationTypes() {
		return $this->locationTypes;
	}

	/**
	 * Sets the locationTypes
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\LocationType> $locationTypes
	 * @return void
	 */
	public function setLocationTypes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $locationTypes) {
		$this->locationTypes = $locationTypes;
	}

}


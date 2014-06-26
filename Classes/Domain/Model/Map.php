<?php

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

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Ajaxmap_Domain_Model_Map extends Tx_Ajaxmap_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
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
	 * @validate NotEmpty
	 */
	protected $width;

	/**
	 * height
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $height;

	/**
	 * Center of Map (Geolocation: latitude, longitude - 10.999999,51.777777)
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $mapCenter;

	/**
	 * initialZoom
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $initialZoom;

	/**
	 * optional Style (json Array)
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $mapStyle;

	/**
	 * disable default UI
	 *
	 * @var boolean
	 */
	protected $disableDefaultUi = FALSE;

	/**
	 * Select items for display by category.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category>
	 */
	protected $categories;

	/**
	 * regions
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Region>
	 */
	protected $regions;

	/**
	 * Display selected places as markers.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Place>
	 */
	protected $places;

	/**
	 * Selected places by location type.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_LocationType>
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
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->categories = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->regions = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->places = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->locationTypes = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Adds a Region
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Region $region
	 * @return void
	 */
	public function addRegion(Tx_Ajaxmap_Domain_Model_Region $region) {
		$this->regions->attach($region);
	}

	/**
	 * Removes a Region
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Region $regionToRemove The Region to be removed
	 * @return void
	 */
	public function removeRegion(Tx_Ajaxmap_Domain_Model_Region $regionToRemove) {
		$this->regions->detach($regionToRemove);
	}

	/**
	 * Returns the regions
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Region> $regions
	 */
	public function getRegions() {
		return $this->regions;
	}

	/**
	 * Sets the regions
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Region> $regions
	 * @return void
	 */
	public function setRegions(Tx_Extbase_Persistence_ObjectStorage $regions) {
		$this->regions = $regions;
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
	 * Adds a Category
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Category $category
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> categories
	 */
	public function addCategory(Tx_Ajaxmap_Domain_Model_Category $category) {
		$this->categories->attach($category);
	}

	/**
	 * Removes a Category
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Category $categoryToRemove The Category to be removed
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> categories
	 */
	public function removeCategory(Tx_Ajaxmap_Domain_Model_Category $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}

	/**
	 * Returns the categories
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Sets the categories
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> $categories
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> categories
	 */
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Adds a Place
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Place $place
	 * @return void
	 */
	public function addPlace(Tx_Ajaxmap_Domain_Model_Place $place) {
		$this->places->attach($place);
	}

	/**
	 * Removes a Place
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Place $placeToRemove The Place to be removed
	 * @return void
	 */
	public function removePlace(Tx_Ajaxmap_Domain_Model_Place $placeToRemove) {
		$this->places->detach($placeToRemove);
	}

	/**
	 * Returns the places
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Place> $places
	 */
	public function getPlaces() {
		return $this->places;
	}

	/**
	 * Sets the places
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Place> $places
	 * @return void
	 */
	public function setPlaces(Tx_Extbase_Persistence_ObjectStorage $places) {
		$this->places = $places;
	}

	/**
	 * Returns the categories as multidimensional array.
	 * Child categories will be included as nested array until three depth.
	 *
	 * @param int> $treeDepth
	 * @return array
	 * @todo read tree depth from typoScript
	 */
	public function getCategoriesArray($treeDepth = 5) {
		$categories = array();
		if ($this->getCategories()){
			$categoriesObjArray = $this->getCategories()->toArray();
			foreach ($categoriesObjArray as $category){
				array_push($categories, $category->toArray());
			}
		}		
		return $categories;
	}

	/**
	 * Adds a LocationType
	 *
	 * @param Tx_Ajaxmap_Domain_Model_LocationType $locationType
	 * @return void
	 */
	public function addLocationType(Tx_Ajaxmap_Domain_Model_LocationType $locationType) {
		$this->locationTypes->attach($locationType);
	}

	/**
	 * Removes a LocationType
	 *
	 * @param Tx_Ajaxmap_Domain_Model_LocationType $locationTypeToRemove The LocationType to be removed
	 * @return void
	 */
	public function removeLocationType(Tx_Ajaxmap_Domain_Model_LocationType $locationTypeToRemove) {
		$this->locationTypes->detach($locationTypeToRemove);
	}

	/**
	 * Returns the locationTypes
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_LocationType> $locationTypes
	 */
	public function getLocationTypes() {
		return $this->locationTypes;
	}
    
    /**
     * Returns the location types as array.
     *
     * @return array
     */
    public function getLocationTypesArray() {
        $locationTypes = array();
        if ($this->getLocationTypes()){
            $locationTypesObjArray = $this->getLocationTypes()->toArray();
            foreach ($locationTypesObjArray as $location){
                $currLocation = array(
                    'key' => $location->getUid(),
                    'title' => $location->getTitle(),
                    'description' => $location->getDescription(),
                    'markerIcon' => $location->getIcon()
                );
                array_push($locationTypes, $currLocation);
            }
        }       
        return $locationTypes;
    }
    
	/**
	 * Sets the locationTypes
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_LocationType> $locationTypes
	 * @return void
	 */
	public function setLocationTypes(Tx_Extbase_Persistence_ObjectStorage $locationTypes) {
		$this->locationTypes = $locationTypes;
	}

}
?>

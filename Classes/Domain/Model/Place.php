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
class Tx_Ajaxmap_Domain_Model_Place extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Geographic location - defined by its latitude and longitude
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
	 * category
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category>
	 */
	protected $category;

	/**
	 * type
	 *
	 * @var Tx_Ajaxmap_Domain_Model_LocationType
	 */
	protected $type;

	/**
	 * regions
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Region>
	 */
	protected $regions;

	/**
	 * Add content.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Content>
	 */
	protected $content;

	/**
	 * Add address
	 *
	 * @var Tx_Ajaxmap_Domain_Model_Address
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
		$this->category = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->regions = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->content = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Adds a Category
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Category $category
	 * @return void
	 */
	public function addCategory(Tx_Ajaxmap_Domain_Model_Category $category) {
		$this->category->attach($category);
	}

	/**
	 * Removes a Category
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Category $categoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeCategory(Tx_Ajaxmap_Domain_Model_Category $categoryToRemove) {
		$this->category->detach($categoryToRemove);
	}

	/**
	 * Returns the category
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> $category
	 * @return void
	 */
	public function setCategory(Tx_Extbase_Persistence_ObjectStorage $category) {
		$this->category = $category;
	}

	/**
	 * Returns the type
	 *
	 * @return Tx_Ajaxmap_Domain_Model_LocationType $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param Tx_Ajaxmap_Domain_Model_LocationType $type
	 * @return void
	 */
	public function setType(Tx_Ajaxmap_Domain_Model_LocationType $type) {
		$this->type = $type;
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
	 * Adds a
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Content $content
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Content> content
	 */
	public function addContent($content) {
		$this->content->attach($content);
	}

	/**
	 * Removes a
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Content $contentToRemove The Content to be removed
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Content> content
	 */
	public function removeContent($contentToRemove) {
		$this->content->detach($contentToRemove);
	}

	/**
	 * Returns the content
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Content> content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the content
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Content> $content
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Content> content
	 */
	public function setContent(Tx_Extbase_Persistence_ObjectStorage $content) {
		$this->content = $content;
	}

	/**
	 * Returns the address
	 *
	 * @return Tx_Ajaxmap_Domain_Model_Address $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Address $address
	 * @return void
	 */
	public function setAddress(Tx_Ajaxmap_Domain_Model_Address $address) {
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
?>

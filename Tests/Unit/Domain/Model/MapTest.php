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
 * Test case for class Tx_Ajaxmap_Domain_Model_Map.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ajax Map
 *
 * @author Dirk Wenzel <wenzel@webfox01.de>
 */
class Tx_Ajaxmap_Domain_Model_MapTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Ajaxmap_Domain_Model_Map
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Ajaxmap_Domain_Model_Map();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getTypeReturnsInitialNull() { 
		$this->assertNull(
			$this->fixture->getType()
		);
	}

	/**
	 * @test
	 */
	public function setTypeForIntegerSetsType() { 
		$this->fixture->setType(12);

		$this->assertSame(
			12,
			$this->fixture->getType()
		);
	}
	
	/**
	 * @test
	 */
	public function getWidthReturnsInitialNull() { 
		$this->assertNull(
			$this->fixture->getWidth()
		);
	}

	/**
	 * @test
	 */
	public function setWidthForIntegerSetsWidth() { 
		$this->fixture->setWidth(12);

		$this->assertSame(
			12,
			$this->fixture->getWidth()
		);
	}
	
	/**
	 * @test
	 */
	public function getHeightReturnsInitialNull() { 
		$this->assertNull(
			$this->fixture->getHeight()
		);
	}

	/**
	 * @test
	 */
	public function setHeightForIntegerSetsHeight() { 
		$this->fixture->setHeight(12);

		$this->assertSame(
			12,
			$this->fixture->getHeight()
		);
	}
	
	/**
	 * @test
	 */
	public function getMapCenterReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getMapCenter()
		);
	}

	/**
	 * @test
	 */
	public function setMapCenterForStringSetsMapCenter() { 
		$this->fixture->setMapCenter('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMapCenter()
		);
	}
	
	/**
	 * @test
	 */
	public function getInitialZoomReturnsInitialValueForInteger() { 
		$this->assertNull(
			$this->fixture->getInitialZoom()
		);
	}

	/**
	 * @test
	 */
	public function setInitialZoomForIntegerSetsInitialZoom() { 
		$this->fixture->setInitialZoom(12);

		$this->assertSame(
			12,
			$this->fixture->getInitialZoom()
		);
	}
	
	/**
	 * @test
	 */
	public function getMapStyleReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getMapStyle()
		);
	}

	/**
	 * @test
	 */
	public function setMapStyleForStringSetsMapStyle() { 
		$this->fixture->setMapStyle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMapStyle()
		);
	}
	
	/**
	 * @test
	 */
	public function getDisableDefaultUiReturnsInitialValueForBoolean() { 
		$this->assertSame(
			FALSE,
			$this->fixture->getDisableDefaultUi()
		);
	}

	/**
	 * @test
	 */
	public function setDisableDefaultUiForBooleanSetsDisableDefaultUi() { 
		$this->fixture->setDisableDefaultUi(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getDisableDefaultUi()
		);
	}

	/**
	 * @test
	 */
	public function isDisableDefaultUiForBooleanReturnsInitialFalse() {
		$this->assertFalse(
				$this->fixture->isDisableDefaultUi()
		);
	}

	/**
	 * @test
	 */
	public function isDisableDefaultUiForBooleanReturnsIsDefaultUi() {
		$this->fixture->setDisableDefaultUi(TRUE);
		$this->assertTrue(
				$this->fixture->isDisableDefaultUi()
		);
	}

	/**
	 * @test
	 */
	public function getCategoriesReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_Category() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function setCategoriesForObjectStorageContainingTx_Ajaxmap_Domain_Model_CategorySetsCategories() { 
		$category = new Tx_Ajaxmap_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategories = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategories->attach($category);
		$this->fixture->setCategories($objectStorageHoldingExactlyOneCategories);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCategories,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategories() {
		$category = new Tx_Ajaxmap_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategory = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->addCategory($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategories() {
		$category = new Tx_Ajaxmap_Domain_Model_Category();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($category);
		$localObjectStorage->detach($category);
		$this->fixture->addCategory($category);
		$this->fixture->removeCategory($category);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function getRegionsReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_Region() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function setRegionsForObjectStorageContainingTx_Ajaxmap_Domain_Model_RegionSetsRegions() { 
		$region = new Tx_Ajaxmap_Domain_Model_Region();
		$objectStorageHoldingExactlyOneRegions = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneRegions->attach($region);
		$this->fixture->setRegions($objectStorageHoldingExactlyOneRegions);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRegions,
			$this->fixture->getRegions()
		);
	}
	
	/**
	 * @test
	 */
	public function addRegionToObjectStorageHoldingRegions() {
		$region = new Tx_Ajaxmap_Domain_Model_Region();
		$objectStorageHoldingExactlyOneRegion = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneRegion->attach($region);
		$this->fixture->addRegion($region);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRegion,
			$this->fixture->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function removeRegionFromObjectStorageHoldingRegions() {
		$region = new Tx_Ajaxmap_Domain_Model_Region();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($region);
		$localObjectStorage->detach($region);
		$this->fixture->addRegion($region);
		$this->fixture->removeRegion($region);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getRegions()
		);
	}
	
	/**
	 * @test
	 */
	public function getPlacesReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_Place() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPlaces()
		);
	}

	/**
	 * @test
	 */
	public function setPlacesForObjectStorageContainingTx_Ajaxmap_Domain_Model_PlaceSetsPlaces() { 
		$place = new Tx_Ajaxmap_Domain_Model_Place();
		$objectStorageHoldingExactlyOnePlaces = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOnePlaces->attach($place);
		$this->fixture->setPlaces($objectStorageHoldingExactlyOnePlaces);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePlaces,
			$this->fixture->getPlaces()
		);
	}
	
	/**
	 * @test
	 */
	public function addPlaceToObjectStorageHoldingPlaces() {
		$place = new Tx_Ajaxmap_Domain_Model_Place();
		$objectStorageHoldingExactlyOnePlace = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOnePlace->attach($place);
		$this->fixture->addPlace($place);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePlace,
			$this->fixture->getPlaces()
		);
	}

	/**
	 * @test
	 */
	public function removePlaceFromObjectStorageHoldingPlaces() {
		$place = new Tx_Ajaxmap_Domain_Model_Place();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($place);
		$localObjectStorage->detach($place);
		$this->fixture->addPlace($place);
		$this->fixture->removePlace($place);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPlaces()
		);
	}
	
	/**
	 * @test
	 */
	public function getLocationTypesReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_LocationType() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLocationTypes()
		);
	}

	/**
	 * @test
	 */
	public function setLocationTypesForObjectStorageContainingTx_Ajaxmap_Domain_Model_LocationTypeSetsLocationTypes() { 
		$locationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$objectStorageHoldingExactlyOneLocationTypes = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLocationTypes->attach($locationType);
		$this->fixture->setLocationTypes($objectStorageHoldingExactlyOneLocationTypes);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLocationTypes,
			$this->fixture->getLocationTypes()
		);
	}
	
	/**
	 * @test
	 */
	public function addLocationTypeToObjectStorageHoldingLocationTypes() {
		$locationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$objectStorageHoldingExactlyOneLocationType = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLocationType->attach($locationType);
		$this->fixture->addLocationType($locationType);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLocationType,
			$this->fixture->getLocationTypes()
		);
	}

	/**
	 * @test
	 */
	public function removeLocationTypeFromObjectStorageHoldingLocationTypes() {
		$locationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($locationType);
		$localObjectStorage->detach($locationType);
		$this->fixture->addLocationType($locationType);
		$this->fixture->removeLocationType($locationType);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLocationTypes()
		);
	}

	/**
	 * @test
	 */
	public function getLocationTypesArrayReturnsInitialEmptyArray() {
		$emptyArray = array();
		$this->assertSame(
				$this->fixture->getLocationTypesArray(),
				$emptyArray
		);
	}

	/**
	 * @test
	 */
	public function getLocationTypesArrayReturnsArrayOfLocationTypes() {
		$firstLocationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$secondLocationType = new Tx_Ajaxmap_Domain_Model_LocationType();

		$this->fixture->addLocationType($firstLocationType);
		$this->fixture->addLocationType($secondLocationType);

		$result = array(
				0 => array(
					'key' => null,
					'title' => null,
					'description' => null,
					'markerIcon' => null,
				),
				1 => array(
					'key' => null,
					'title' => null,
					'description' => null,
					'markerIcon' => null,
				),
		);

		$this->assertSame(
				$this->fixture->getLocationTypesArray(),
				$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsInitialValueForArray() {
		$result = array (
				'categories' => array(),
				'categoriesArray' => array(),
				'disableDefaultUi' => FALSE,
				'height' => null,
				'initialZoom' => null,
				'locationTypes' => array(),
				'locationTypesArray' => array(),
				'mapCenter' => null,
				'mapStyle' => null,
				'pid' => null,
				'places' => array(),
				'regions' => array(),
				'title' => null,
				'type' => null,
				'uid' => null,
				'width' => null,
		);

		$this->assertSame(
				$this->fixture->toArray(),
				$result
		);
	}

		/**
		 * @test
		 */
		public function toArrayReturnsCorrectValuesForSimpleProperties() {
			$this->fixture->setDisableDefaultUi(TRUE);
			$this->fixture->setHeight(123);
			$this->fixture->setInitialZoom(12);
			
			$valueArray = $this->fixture->toArray();

			$this->assertSame(
					$valueArray['disableDefaultUi'],
					TRUE
			);

			$this->assertSame(
					$valueArray['height'],
					123
			);

			$this->assertSame(
					$valueArray['initialZoom'],
					12
			);

		}

}
?>

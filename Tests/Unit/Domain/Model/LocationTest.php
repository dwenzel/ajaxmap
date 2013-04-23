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
 * Test case for class Tx_Ajaxmap_Domain_Model_Location.
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
class Tx_Ajaxmap_Domain_Model_LocationTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Ajaxmap_Domain_Model_Location
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Ajaxmap_Domain_Model_Location();
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
	public function getLatitudeReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getLatitude()
		);
	}

	/**
	 * @test
	 */
	public function setLatitudeForFloatSetsLatitude() { 
		$this->fixture->setLatitude(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getLatitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getLongitudeReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getLongitude()
		);
	}

	/**
	 * @test
	 */
	public function setLongitudeForFloatSetsLongitude() { 
		$this->fixture->setLongitude(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getLongitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getRegionReturnsInitialValueForTx_Ajaxmap_Domain_Model_Region() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getRegion()
		);
	}

	/**
	 * @test
	 */
	public function setRegionForTx_Ajaxmap_Domain_Model_RegionSetsRegion() { 
		$dummyObject = new Tx_Ajaxmap_Domain_Model_Region();
		$this->fixture->setRegion($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getRegion()
		);
	}
	
	/**
	 * @test
	 */
	public function getCategoryReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_Category() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategory()
		);
	}

	/**
	 * @test
	 */
	public function setCategoryForObjectStorageContainingTx_Ajaxmap_Domain_Model_CategorySetsCategory() { 
		$category = new Tx_Ajaxmap_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategory = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->setCategory($objectStorageHoldingExactlyOneCategory);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategory()
		);
	}
	
	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategory() {
		$category = new Tx_Ajaxmap_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategory = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->addCategory($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategory()
		);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategory() {
		$category = new Tx_Ajaxmap_Domain_Model_Category();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($category);
		$localObjectStorage->detach($category);
		$this->fixture->addCategory($category);
		$this->fixture->removeCategory($category);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCategory()
		);
	}
	
	/**
	 * @test
	 */
	public function getLocationTypeReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_LocationType() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLocationType()
		);
	}

	/**
	 * @test
	 */
	public function setLocationTypeForObjectStorageContainingTx_Ajaxmap_Domain_Model_LocationTypeSetsLocationType() { 
		$locationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$objectStorageHoldingExactlyOneLocationType = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLocationType->attach($locationType);
		$this->fixture->setLocationType($objectStorageHoldingExactlyOneLocationType);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLocationType,
			$this->fixture->getLocationType()
		);
	}
	
	/**
	 * @test
	 */
	public function addLocationTypeToObjectStorageHoldingLocationType() {
		$locationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$objectStorageHoldingExactlyOneLocationType = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLocationType->attach($locationType);
		$this->fixture->addLocationType($locationType);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLocationType,
			$this->fixture->getLocationType()
		);
	}

	/**
	 * @test
	 */
	public function removeLocationTypeFromObjectStorageHoldingLocationType() {
		$locationType = new Tx_Ajaxmap_Domain_Model_LocationType();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($locationType);
		$localObjectStorage->detach($locationType);
		$this->fixture->addLocationType($locationType);
		$this->fixture->removeLocationType($locationType);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLocationType()
		);
	}
	
}
?>
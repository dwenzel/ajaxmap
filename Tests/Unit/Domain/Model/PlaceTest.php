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
 * Test case for class Tx_Ajaxmap_Domain_Model_Place.
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
class Tx_Ajaxmap_Domain_Model_PlaceTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Ajaxmap_Domain_Model_Place
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Ajaxmap_Domain_Model_Place();
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
	public function getGeoCoordinatesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setGeoCoordinatesForStringSetsGeoCoordinates() { 
		$this->fixture->setGeoCoordinates('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getGeoCoordinates()
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
	public function getInfoReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setInfoForStringSetsInfo() { 
		$this->fixture->setInfo('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getInfo()
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
	public function getTypeReturnsInitialValueForTx_Ajaxmap_Domain_Model_LocationType() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getType()
		);
	}

	/**
	 * @test
	 */
	public function setTypeForTx_Ajaxmap_Domain_Model_LocationTypeSetsType() { 
		$dummyObject = new Tx_Ajaxmap_Domain_Model_LocationType();
		$this->fixture->setType($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getType()
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
	public function getContentReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_Content() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getContent()
		);
	}

	/**
	 * @test
	 */
	public function setContentForObjectStorageContainingTx_Ajaxmap_Domain_Model_ContentSetsContent() { 
		$content = new Tx_Ajaxmap_Domain_Model_Content();
		$objectStorageHoldingExactlyOneContent = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneContent->attach($content);
		$this->fixture->setContent($objectStorageHoldingExactlyOneContent);

		$this->assertSame(
			$objectStorageHoldingExactlyOneContent,
			$this->fixture->getContent()
		);
	}
	
	/**
	 * @test
	 */
	public function addContentToObjectStorageHoldingContent() {
		$content = new Tx_Ajaxmap_Domain_Model_Content();
		$objectStorageHoldingExactlyOneContent = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneContent->attach($content);
		$this->fixture->addContent($content);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneContent,
			$this->fixture->getContent()
		);
	}

	/**
	 * @test
	 */
	public function removeContentFromObjectStorageHoldingContent() {
		$content = new Tx_Ajaxmap_Domain_Model_Content();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($content);
		$localObjectStorage->detach($content);
		$this->fixture->addContent($content);
		$this->fixture->removeContent($content);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getContent()
		);
	}
	
	/**
	 * @test
	 */
	public function getAddressReturnsInitialValueForTx_Ajaxmap_Domain_Model_Address() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function setAddressForTx_Ajaxmap_Domain_Model_AddressSetsAddress() { 
		$dummyObject = new Tx_Ajaxmap_Domain_Model_Address();
		$this->fixture->setAddress($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getAddress()
		);
	}
	
}
?>
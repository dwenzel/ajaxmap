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
 * Test case for class Tx_Ajaxmap_Domain_Model_Category.
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
class Tx_Ajaxmap_Domain_Model_CategoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Ajaxmap_Domain_Model_Category
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Ajaxmap_Domain_Model_Category();
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
	public function getIconReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setIconForStringSetsIcon() { 
		$this->fixture->setIcon('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getIcon()
		);
	}
	
	/**
	 * @test
	 */
	public function getChildCategoriesReturnsInitialValueForObjectStorageContainingTx_Ajaxmap_Domain_Model_Category() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getChildCategories()
		);
	}

	/**
	 * @test
	 */
	public function setChildCategoriesForObjectStorageContainingTx_Ajaxmap_Domain_Model_CategorySetsChildCategories() { 
		$childCategory = new Tx_Ajaxmap_Domain_Model_Category();
		$objectStorageHoldingExactlyOneChildCategories = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneChildCategories->attach($childCategory);
		$this->fixture->setChildCategories($objectStorageHoldingExactlyOneChildCategories);

		$this->assertSame(
			$objectStorageHoldingExactlyOneChildCategories,
			$this->fixture->getChildCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function addChildCategoryToObjectStorageHoldingChildCategories() {
		$childCategory = new Tx_Ajaxmap_Domain_Model_Category();
		$objectStorageHoldingExactlyOneChildCategory = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneChildCategory->attach($childCategory);
		$this->fixture->addChildCategory($childCategory);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneChildCategory,
			$this->fixture->getChildCategories()
		);
	}

	/**
	 * @test
	 */
	public function removeChildCategoryFromObjectStorageHoldingChildCategories() {
		$childCategory = new Tx_Ajaxmap_Domain_Model_Category();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($childCategory);
		$localObjectStorage->detach($childCategory);
		$this->fixture->addChildCategory($childCategory);
		$this->fixture->removeChildCategory($childCategory);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getChildCategories()
		);
	}
	
}
?>
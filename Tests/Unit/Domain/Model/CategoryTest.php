<?php

namespace Webfox\Ajaxmap\Tests;
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
 * Test case for class Webfox\Ajaxmap\Domain\Model\Category.
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
class CategoryTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var Webfox\Ajaxmap\Domain\Model\Category
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Webfox\Ajaxmap\Domain\Model\Category();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getTitle()
		);
	}

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
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getDescription()
		);
	}

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
	public function getIconReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getIcon()
		);
	}

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
	public function getChildCategoriesReturnsInitialValueForObjectStorageContainingCategory() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getChildCategories()
		);
	}

	/**
	 * @test
	 */
	public function setChildCategoriesForObjectStorageContainingCategorySetsChildCategories() { 
		$childCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$objectStorageHoldingExactlyOneChildCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$childCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$objectStorageHoldingExactlyOneChildCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$childCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($childCategory);
		$localObjectStorage->detach($childCategory);
		$this->fixture->addChildCategory($childCategory);
		$this->fixture->removeChildCategory($childCategory);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getChildCategories()
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsInitialValue() {
		$result = array(
			'childCategories' => Array (),
			'description' => null,
			'icon' => null,
			'pid' => null,
			'title' => null,
			'uid' => null
		);
		$this->assertSame(
			$this->fixture->toArray(),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsArrayWithCorrectValues() {
		$category = new \Webfox\Ajaxmap\Domain\Model\Category();
		$this->fixture->addChildCategory($category);
		$this->fixture->setDescription('foo');
		$this->fixture->setIcon('bar');
		$this->fixture->setPid(1);
		$this->fixture->setTitle('foobar');
		$this->fixture->_setProperty('uid', 2);
		$result = array(
			'childCategories' => array (
					0 => array(
						'childCategories' => array(),
						'description' => null,
						'icon' => null,
						'pid' => null,
						'title' => null,
						'uid' => null
					)
				),
			'description' => 'foo',
			'icon' => 'bar',
			'pid' => 1,
			'title' => 'foobar',
			'uid' => 2
		);
		$this->assertSame(
			$this->fixture->toArray(),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayForCategoryWithTwoChildrenReturnsCorrectArray() {
		$firstCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$secondCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$this->fixture->addChildCategory($firstCategory);
		$this->fixture->addChildCategory($secondCategory);
		$result = array(
				'childCategories' => Array (
					0 => array(
						'childCategories' => Array (),
						'description' => null,
						'icon' => null,
						'pid' => null,
						'title' => null,
						'uid' => null,
					),
					1 => array(
						'childCategories' => Array (),
						'description' => null,
						'icon' => null,
						'pid' => null,
						'title' => null,
						'uid' => null,
					),
				),
				'description' => null,
				'icon' => null,
				'pid' => null,
				'title' => null,
				'uid' => null
		);
		$this->assertSame(
			$this->fixture->toArray(),
			$result
		);
	}

	/**
	 * @test
	 */
	public function toArrayForCategoryWithNestedChildCategoryReturnsCorrectArray() {
		$firstCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$secondCategory = new \Webfox\Ajaxmap\Domain\Model\Category();
		$firstCategory->addChildCategory($secondCategory);
		$this->fixture->addChildCategory($firstCategory);
		$result = array(
				'childCategories' => Array (
					0 => array(
						'childCategories' => Array (
							0 => array(
								'childCategories' => Array (),
								'description' => null,
								'icon' => null,
								'pid' => null,
								'title' => null,
								'uid' => null,
							),
						),
						'description' => null,
						'icon' => null,
						'pid' => null,
						'title' => null,
						'uid' => null,
					),
				),
				'description' => null,
				'icon' => null,
				'pid' => null,
				'title' => null,
				'uid' => null
		);
		$this->assertSame(
			$this->fixture->toArray(),
			$result
		);
	}

}
?>

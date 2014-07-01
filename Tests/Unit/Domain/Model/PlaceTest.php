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
 * Test case for class Webfox\Ajaxmap\Domain\Model\Place.
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
class PlaceTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var Webfox\Ajaxmap\Domain\Model\Place
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Webfox\Ajaxmap\Domain\Model\Place();
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
	public function getGeoCoordinatesReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getGeoCoordinates()
		);
	}

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
	public function getInfoReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getInfo()
		);
	}

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
	public function getCategoryReturnsInitialValueForObjectStorageContainingCategory() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategory()
		);
	}

	/**
	 * @test
	 */
	public function setCategoryForObjectStorageContainingCategorySetsCategory() { 
		$category = new \Webfox\Ajaxmap\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$category = new \Webfox\Ajaxmap\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$category = new \Webfox\Ajaxmap\Domain\Model\Category();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	public function getLocationTypeReturnsInitialValueForLocationLocationType() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getLocationType()
		);
	}

	/**
	 * @test
	 */
	public function setLocationTypeForLocationLocationTypeSetsLocationType() { 
		$dummyObject = new \Webfox\Ajaxmap\Domain\Model\LocationType();
		$this->fixture->setLocationType($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getLocationType()
		);
	}
	
	/**
	 * @test
	 */
	public function getRegionsReturnsInitialValueForObjectStorageContainingRegion() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function setRegionsForObjectStorageContainingRegionSetsRegions() { 
		$region = new \Webfox\Ajaxmap\Domain\Model\Region();
		$objectStorageHoldingExactlyOneRegions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$region = new \Webfox\Ajaxmap\Domain\Model\Region();
		$objectStorageHoldingExactlyOneRegion = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$region = new \Webfox\Ajaxmap\Domain\Model\Region();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	public function getContentReturnsInitialValueForObjectStorageContainingContent() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getContent()
		);
	}

	/**
	 * @test
	 */
	public function setContentForObjectStorageContainingContentSetsContent() { 
		$content = new \Webfox\Ajaxmap\Domain\Model\Content();
		$objectStorageHoldingExactlyOneContent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$content = new \Webfox\Ajaxmap\Domain\Model\Content();
		$objectStorageHoldingExactlyOneContent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$content = new \Webfox\Ajaxmap\Domain\Model\Content();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	public function getAddressReturnsInitialValueForAddress() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function setAddressForAddressSetsAddress() { 
		$dummyObject = new \Webfox\Ajaxmap\Domain\Model\Address();
		$this->fixture->setAddress($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function toArrayReturnsInitialValueForArray() {
		$result = array(
			'address' => null,
			'category' => Array (),
			'content' => Array (),
			'description' => null,
			'geoCoordinates' => null,
			'info' => null,
			'locationType' => null,
			'pid' => null,
			'regions' => Array (),
			'title' => null,
			'uid' => null,
		);
		$this->assertSame(
				$this->fixture->toArray(),
				$result
		);
	}
}
?>

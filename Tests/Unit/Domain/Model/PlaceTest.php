<?php

namespace DWenzel\Ajaxmap\Tests;
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
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Place.
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
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\Ajaxmap\DomainObject\CategorizableInterface;

/**
 * Class PlaceTest
 *
 * @package DWenzel\Ajaxmap\Tests
 * @coversDefaultClass DWenzel\Ajaxmap\Domain\Model\Place
 */
class PlaceTest extends UnitTestCase {
	/**
	 * @var \DWenzel\Ajaxmap\Domain\Model\Place
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \DWenzel\Ajaxmap\Domain\Model\Place();
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
	public function getPlaceGroupsReturnsInitialValueForObjectStorageContainingPlaceGroups() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function setPlaceGroupsForObjectStorageContainingPlaceGroupsSetsPlaceGroups() {
		$category = new \DWenzel\Ajaxmap\Domain\Model\PlaceGroup();
		$objectStorageHoldingExactlyOnePlaceGroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePlaceGroup->attach($category);
		$this->fixture->setPlaceGroups($objectStorageHoldingExactlyOnePlaceGroup);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePlaceGroup,
			$this->fixture->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function addPlaceGroupToObjectStorageHoldingPlaceGroups() {
		$category = new \DWenzel\Ajaxmap\Domain\Model\PlaceGroup();
		$objectStorageHoldingExactlyOnePlaceGroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePlaceGroup->attach($category);
		$this->fixture->addPlaceGroup($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePlaceGroup,
			$this->fixture->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function removePlaceGroupFromObjectStorageHoldingPlaceGroup() {
		$placeGroup = new \DWenzel\Ajaxmap\Domain\Model\PlaceGroup();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($placeGroup);
		$localObjectStorage->detach($placeGroup);
		$this->fixture->addPlaceGroup($placeGroup);
		$this->fixture->removePlaceGroup($placeGroup);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPlaceGroups()
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
		$dummyObject = new \DWenzel\Ajaxmap\Domain\Model\LocationType();
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
		$region = new \DWenzel\Ajaxmap\Domain\Model\Region();
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
		$region = new \DWenzel\Ajaxmap\Domain\Model\Region();
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
		$region = new \DWenzel\Ajaxmap\Domain\Model\Region();
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
		$content = new \DWenzel\Ajaxmap\Domain\Model\Content();
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
		$content = new \DWenzel\Ajaxmap\Domain\Model\Content();
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
		$content = new \DWenzel\Ajaxmap\Domain\Model\Content();
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
		$dummyObject = new \DWenzel\Ajaxmap\Domain\Model\Address();
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
			'categories' => Array(),
			'content' => null,
			'content' => Array (),
			'description' => null,
			'geoCoordinates' => null,
			'info' => null,
			'locationType' => null,
			'pid' => null,
			'placeGroups' => Array (),
			'regions' => Array (),
			'title' => null,
			'uid' => null,
		);
		$this->assertSame(
				$this->fixture->toArray(),
				$result
		);
	}

	/**
	 * @test
	 * @covers ::__construct
	 */
	public function constructorInitializesCategoriesWithStorageObject() {
		$this->fixture->__construct();
		$this->assertInstanceOf(
			ObjectStorage::class,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function objectImplementsCategorizableInterface() {
		$this->assertInstanceOf(
			CategorizableInterface::class,
			$this->fixture
		);
	}
}


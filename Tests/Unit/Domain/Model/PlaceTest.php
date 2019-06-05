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

use DWenzel\Ajaxmap\Domain\Model\Address;
use DWenzel\Ajaxmap\Domain\Model\Content;
use DWenzel\Ajaxmap\Domain\Model\LocationType;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Model\PlaceGroup;
use DWenzel\Ajaxmap\Domain\Model\Region;
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
	 * @var Place
	 */
	protected $subject;

	public function setUp() {
		$this->subject = new Place();
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertNull(
				$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getGeoCoordinatesReturnsInitialValueForString() {
		$this->assertNull(
				$this->subject->getGeoCoordinates()
		);
	}

	/**
	 * @test
	 */
	public function setGeoCoordinatesForStringSetsGeoCoordinates() {
		$this->subject->setGeoCoordinates('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->subject->getGeoCoordinates()
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertNull(
				$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() {
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function getInfoReturnsInitialValueForString() {
		$this->assertNull(
				$this->subject->getInfo()
		);
	}

	/**
	 * @test
	 */
	public function setInfoForStringSetsInfo() {
		$this->subject->setInfo('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->subject->getInfo()
		);
	}

	/**
	 * @test
	 */
	public function getPlaceGroupsReturnsInitialValueForObjectStorageContainingPlaceGroups() {
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function setPlaceGroupsForObjectStorageContainingPlaceGroupsSetsPlaceGroups() {
		$category = new PlaceGroup();
		$objectStorageHoldingExactlyOnePlaceGroup = new ObjectStorage();
		$objectStorageHoldingExactlyOnePlaceGroup->attach($category);
		$this->subject->setPlaceGroups($objectStorageHoldingExactlyOnePlaceGroup);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePlaceGroup,
			$this->subject->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function addPlaceGroupToObjectStorageHoldingPlaceGroups() {
		$category = new PlaceGroup();
		$objectStorageHoldingExactlyOnePlaceGroup = new ObjectStorage();
		$objectStorageHoldingExactlyOnePlaceGroup->attach($category);
		$this->subject->addPlaceGroup($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePlaceGroup,
			$this->subject->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function removePlaceGroupFromObjectStorageHoldingPlaceGroup() {
		$placeGroup = new PlaceGroup();
		$localObjectStorage = new ObjectStorage();
		$localObjectStorage->attach($placeGroup);
		$localObjectStorage->detach($placeGroup);
		$this->subject->addPlaceGroup($placeGroup);
		$this->subject->removePlaceGroup($placeGroup);

		$this->assertEquals(
			$localObjectStorage,
			$this->subject->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function getLocationTypeReturnsInitialValueForLocationLocationType() {
		$this->assertEquals(
			NULL,
			$this->subject->getLocationType()
		);
	}

	/**
	 * @test
	 */
	public function setLocationTypeForLocationLocationTypeSetsLocationType() {
		$dummyObject = new LocationType();
		$this->subject->setLocationType($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->subject->getLocationType()
		);
	}

	/**
	 * @test
	 */
	public function getRegionsReturnsInitialValueForObjectStorageContainingRegion() {
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function setRegionsForObjectStorageContainingRegionSetsRegions() {
		$region = new Region();
		$objectStorageHoldingExactlyOneRegions = new ObjectStorage();
		$objectStorageHoldingExactlyOneRegions->attach($region);
		$this->subject->setRegions($objectStorageHoldingExactlyOneRegions);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRegions,
			$this->subject->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function addRegionToObjectStorageHoldingRegions() {
		$region = new Region();
		$objectStorageHoldingExactlyOneRegion = new ObjectStorage();
		$objectStorageHoldingExactlyOneRegion->attach($region);
		$this->subject->addRegion($region);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRegion,
			$this->subject->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function removeRegionFromObjectStorageHoldingRegions() {
		$region = new Region();
		$localObjectStorage = new ObjectStorage();
		$localObjectStorage->attach($region);
		$localObjectStorage->detach($region);
		$this->subject->addRegion($region);
		$this->subject->removeRegion($region);

		$this->assertEquals(
			$localObjectStorage,
			$this->subject->getRegions()
		);
	}

	/**
	 * @test
	 */
	public function getContentReturnsInitialValueForObjectStorageContainingContent() {
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getContent()
		);
	}

	/**
	 * @test
	 */
	public function setContentForObjectStorageContainingContentSetsContent() {
		$content = new Content();
		$objectStorageHoldingExactlyOneContent = new ObjectStorage();
		$objectStorageHoldingExactlyOneContent->attach($content);
		$this->subject->setContent($objectStorageHoldingExactlyOneContent);

		$this->assertSame(
			$objectStorageHoldingExactlyOneContent,
			$this->subject->getContent()
		);
	}

	/**
	 * @test
	 */
	public function addContentToObjectStorageHoldingContent() {
		$content = new Content();
		$objectStorageHoldingExactlyOneContent = new ObjectStorage();
		$objectStorageHoldingExactlyOneContent->attach($content);
		$this->subject->addContent($content);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneContent,
			$this->subject->getContent()
		);
	}

	/**
	 * @test
	 */
	public function removeContentFromObjectStorageHoldingContent() {
		$content = new Content();
		$localObjectStorage = new ObjectStorage();
		$localObjectStorage->attach($content);
		$localObjectStorage->detach($content);
		$this->subject->addContent($content);
		$this->subject->removeContent($content);

		$this->assertEquals(
			$localObjectStorage,
			$this->subject->getContent()
		);
	}

	/**
	 * @test
	 */
	public function getAddressReturnsInitialValueForAddress() {
		$this->assertEquals(
			NULL,
			$this->subject->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function setAddressForAddressSetsAddress() {
		$dummyObject = new Address();
		$this->subject->setAddress($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->subject->getAddress()
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
				$this->subject->toArray(),
				$result
		);
	}

	/**
	 * @test
	 * @covers ::__construct
	 */
	public function constructorInitializesCategoriesWithStorageObject() {
		$this->subject->__construct();
		$this->assertInstanceOf(
			ObjectStorage::class,
			$this->subject->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function objectImplementsCategorizableInterface() {
		$this->assertInstanceOf(
			CategorizableInterface::class,
			$this->subject
		);
	}

	public function testGetGeoCoordinatesReturnsCoordinatesFromAddressIfEmpty()
    {
        $latitude = '1.5';
        $longitude =  '2.4';
        $address = $this->getMockBuilder(Address::class)
            ->setMethods(['getGeoCoordinates'])
            ->getMock();

        $address->setLatitude($latitude);
        $address->setLongitude($longitude);
        $this->subject->setAddress($address);

        $expectedCoordinates = $latitude . ',' . $longitude;

        $address->expects($this->atLeast(1))
            ->method('getGeoCoordinates')
            ->willReturn($expectedCoordinates);

        $this->assertSame(
            $expectedCoordinates,
            $this->subject->getGeoCoordinates()
        );
    }
}


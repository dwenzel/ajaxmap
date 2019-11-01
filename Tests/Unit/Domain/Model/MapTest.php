<?php

namespace DWenzel\Ajaxmap\Tests;

	/***************************************************************
	 *  Copyright notice
	 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
	 *  All rights reserved
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
	 *  (at your option) any later version.
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

/**
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Map.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package TYPO3
 * @subpackage Ajax Map
 * @author Dirk Wenzel <wenzel@webfox01.de>
 */
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\Ajaxmap\DomainObject\CategorizableInterface;

/**
 * Class MapTest
 *
 * @package DWenzel\Ajaxmap\Tests
 * @coversDefaultClass DWenzel\Ajaxmap\Domain\Model\Map
 */
class MapTest extends UnitTestCase {

	/**
	 * @var \DWenzel\Ajaxmap\Domain\Model\Map
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \DWenzel\Ajaxmap\Domain\Model\Map();
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
			false,
			$this->fixture->getDisableDefaultUi()
		);
	}

	/**
	 * @test
	 */
	public function setDisableDefaultUiForBooleanSetsDisableDefaultUi() {
		$this->fixture->setDisableDefaultUi(true);

		$this->assertSame(
			true,
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
		$this->fixture->setDisableDefaultUi(true);
		$this->assertTrue(
			$this->fixture->isDisableDefaultUi()
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
	public function setPlaceGroupsForObjectStorageContainingCategorySetsPlaceGroups() {
		$placeGroup = new \DWenzel\Ajaxmap\Domain\Model\PlaceGroup();
		$objectStorageHoldingExactlyOnePlaceGroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePlaceGroup->attach($placeGroup);
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
		$placeGroup = new \DWenzel\Ajaxmap\Domain\Model\PlaceGroup();
		$objectStorageHoldingExactlyOnePlaceGroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePlaceGroup->attach($placeGroup);
		$this->fixture->addPlaceGroup($placeGroup);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePlaceGroup,
			$this->fixture->getPlaceGroups()
		);
	}

	/**
	 * @test
	 */
	public function removePlaceGroupFromObjectStorageHoldingPlaceGroups() {
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
	public function getLocationTypesReturnsInitialValueForObjectStorageContainingLocationType() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLocationTypes()
		);
	}

	/**
	 * @test
	 */
	public function setLocationTypesForObjectStorageContainingLocationTypeSetsLocationTypes() {
		$locationType = new \DWenzel\Ajaxmap\Domain\Model\LocationType();
		$objectStorageHoldingExactlyOneLocationTypes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$locationType = new \DWenzel\Ajaxmap\Domain\Model\LocationType();
		$objectStorageHoldingExactlyOneLocationType = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$locationType = new \DWenzel\Ajaxmap\Domain\Model\LocationType();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	public function toArrayReturnsInitialValueForArray() {
		$result = array(
			'categories' => array(),
			'disableDefaultUi' => false,
			'height' => NULL,
			'initialZoom' => NULL,
			'locationTypes' => array(),
			'mapCenter' => NULL,
			'mapStyle' => NULL,
			'pid' => NULL,
			'placeGroups' => array(),
			'regions' => array(),
			'staticLayers' => array(),
			'title' => NULL,
			'type' => NULL,
			'uid' => NULL,
			'width' => NULL,
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
		$this->fixture->setDisableDefaultUi(true);
		$this->fixture->setHeight(123);
		$this->fixture->setInitialZoom(12);

		$valueArray = $this->fixture->toArray();

		$this->assertSame(
			$valueArray['disableDefaultUi'],
			true
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

	/**
	 * @test
	 * @covers ::__construct
	 */
	public function constructorInitializesPlaceGroupsWithStorageObject() {
		$this->fixture->__construct();
		$this->assertInstanceOf(
			'TYPO3\CMS\Extbase\Persistence\ObjectStorage',
			$this->fixture->getPlaceGroups()
		);
	}

	/**
	 * @test
	 * @covers ::__construct
	 */
	public function constructorInitializesRegionsWithStorageObject() {
		$this->fixture->__construct();
		$this->assertInstanceOf(
			'TYPO3\CMS\Extbase\Persistence\ObjectStorage',
			$this->fixture->getRegions()
		);
	}

	/**
	 * @test
	 * @covers ::__construct
	 */
	public function constructorInitializesLocationTypesWithStorageObject() {
		$this->fixture->__construct();
		$this->assertInstanceOf(
			'TYPO3\CMS\Extbase\Persistence\ObjectStorage',
			$this->fixture->getLocationTypes()
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
	public function getStaticLayersReturnsInitialValueForObjectStorageContainingRegion() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getStaticLayers()
		);
	}

	/**
	 * @test
	 */
	public function setStaticLayersForObjectStorageContainingRegionSetsStaticLayers() {
		$region = new \DWenzel\Ajaxmap\Domain\Model\Region();
		$objectStorageHoldingExactlyOneRegions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneRegions->attach($region);
		$this->fixture->setStaticLayers($objectStorageHoldingExactlyOneRegions);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRegions,
			$this->fixture->getStaticLayers()
		);
	}

	/**
	 * @test
	 */
	public function addStaticLayerToObjectStorageHoldingRegions() {
		$region = new \DWenzel\Ajaxmap\Domain\Model\Region();
		$objectStorageHoldingExactlyOneRegion = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneRegion->attach($region);
		$this->fixture->addStaticLayer($region);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRegion,
			$this->fixture->getStaticLayers()
		);
	}

	/**
	 * @test
	 */
	public function removeStaticLayerFromObjectStorageHoldingRegions() {
		$region = new \DWenzel\Ajaxmap\Domain\Model\Region();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($region);
		$localObjectStorage->detach($region);
		$this->fixture->addStaticLayer($region);
		$this->fixture->removeStaticLayer($region);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getStaticLayers()
		);
	}
}

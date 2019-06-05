<?php

namespace Webfox\Ajaxmap\Tests\Controller;
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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Webfox\Ajaxmap\Controller\MapController;

/**
 * Test case for class \Webfox\Ajaxmap\Controller\MapController.
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
use TYPO3\CMS\Core\Tests\UnitTestCase;
use Webfox\Ajaxmap\Domain\Model\Category;
use Webfox\Ajaxmap\Domain\Model\Map;

/**
 * Class MapControllerTest
 *
 * @package Webfox\Ajaxmap\Tests
 */
class MapControllerTest extends UnitTestCase {

	/**
	 * @var MapController
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = $this->getAccessibleMock (
			'Webfox\\Ajaxmap\\Controller\\MapController',
			array('dummy'), array(), '', FALSE);
		$mockObjectManager = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Object\\ObjectManager',
			array('get'), array(), '', FALSE);
		$this->fixture->_set('objectManager', $mockObjectManager);
		$mapRepository = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\Repository\\MapRepository', array(), array(), '', FALSE
		);
		$categoryRepository = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\Repository\\CategoryRepository', array(), array(), '', FALSE
		);
		$this->fixture->_set('categoryRepository', $categoryRepository);
		$this->regionRepository = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\\Repository\\RegionRepository', array(), array(), '', FALSE
		);
		$this->placeRepository = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\\Repository\\PlaceRepository', array(), array(), '', FALSE
		);
		$placeGroupRepository = $this->getMock(
				'Webfox\\Ajaxmap\\Domain\\Repository\\PlaceGroupRepository', array(), array(), '', FALSE
		);
		$this->fixture->_set('placeGroupRepository', $placeGroupRepository);
		$this->fixture->injectMapRepository($mapRepository);
		$this->fixture->_set('view',
				$this->getMock('TYPO3\\CMS\\Fluid\\View\\TemplateView', array(), array(), '', FALSE));

	}

	/**
	 * @return Map
	 */
	protected function mockMapWithOneCategory() {
		$map = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map', ['getCategories']
		);
		$category = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Category', ['getUid']
		);
		$category->expects($this->any())
			->method('getUid')
			->will($this->returnValue(1));
		$objectStorage = new ObjectStorage();
		$objectStorage->attach($category);
		$map->expects($this->any())
			->method('getCategories')
			->will($this->returnValue($objectStorage));

		return $map;
	}

	/**
	 * @test
	 */
	public function showActionReturnsEmptyJsonWhenMapIsNotSet() {
		$settings = array();
		$configurationManager = $this->getMock(
				'TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'
		);

		$fixture = $this->getAccessibleMock(
				'Webfox\\Ajaxmap\\Controller\\MapController',
				array('showAction'));
		$fixture->expects($this->once())->method('showAction')
			->will($this->returnValue('{}'));
		$fixture->showAction();
	}

	/**
	 * @test
	 */
	public function ajaxListCategoriesActionReturnsEmptyJsonWithEmptyMapId() {
		$emptyJson = json_encode(array());
		$this->assertEquals(
			$emptyJson,
			$this->fixture->ajaxListCategoriesAction()
		);
	}
	/**
	 * @test
	 */
	public function ajaxListCategoriesActionReturnsCategoriesForMapAsJson() {
		$this->markTestIncomplete('method contains static call - refactor TreeUtility::buildObjectTree to consume array');
		$mapId = 1;
		$mockMap = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map',
			array(), array(), '', FALSE);
		$mockCategory = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Category',
			array('getUid'), array(), '', FALSE);
		$mockObjectStorage = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage',
			array(), array(), '', FALSE);
		$mockCategoryRepository = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Repository\\CategoryRepository',
			array('findByChildren'), array(), '', FALSE);
		$mockCategory->expects($this->exactly(2))
			->method('toArray')
			->will($this->returnValue(array( 'bar')));
		$mockObjectStorage->expects($this->once())
			->method('toArray')
			->will($this->returnValue(array($mockCategory, $mockCategory)));
		$mockMap->expects($this->exactly(2))
			->method('getCategories')
			->will($this->returnValue($mockObjectStorage));
		$this->fixture->_get('mapRepository')->expects($this->once())
			->method('findByUid')
			->with($mapId)
			->will($this->returnValue($mockMap));
		$mockCategory->expects($this->exactly(2))
			->method('getUid')
			->will($this->returnValue(1));
		$this->fixture->_get('categoryRepository')->expects($this->once())
			->method('findChildren')
			->with('1,1')
			->will($this->returnValue($mockCategory));
		$categoriesJson = '[["bar"],["bar"]]';
		$this->assertEquals(
			$categoriesJson,
			$this->fixture->ajaxListCategoriesAction($mapId)
		);
	}

	/**
	 * @test
	 */
	public function ajaxListPlaceGroupsActionReturnsEmptyJsonWithEmptyMapId() {
		$emptyJson = json_encode(array());
		$this->assertEquals(
			$emptyJson,
			$this->fixture->ajaxListPlaceGroupsAction()
		);
	}

	/**
	 * @test
	 */
	public function ajaxListPlaceGroupsReturnsPlaceGroupsForMapAsJson() {
		$this->markTestIncomplete('method contains static call - refactor TreeUtility::buildObjectTree to consume array');
		$mapId = 1;
		$mockMap = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map',
			array(), array(), '', FALSE);
		$mockPlaceGroup = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\PlaceGroup',
			array(), array(), '', FALSE);
		$mockObjectStorage = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage',
			array(), array(), '', FALSE);

		$mockPlaceGroup->expects($this->exactly(2))
			->method('toArray')
			->will($this->returnValue(array( 'bar')));
		$mockObjectStorage->expects($this->once())
			->method('toArray')
			->will($this->returnValue(array($mockPlaceGroup, $mockPlaceGroup)));
		$mockMap->expects($this->exactly(2))
			->method('getPlaceGroups')
			->will($this->returnValue($mockObjectStorage));
		$this->fixture->_get('mapRepository')->expects($this->once())
			->method('findByUid')
			->with($mapId)
			->will($this->returnValue($mockMap));
		$this->fixture->_get('placeGroupRepository')->expects($this->once())
			->method('findChildren')
			->with(',')
			->will($this->returnValue($mockPlaceGroup));
		$categoriesJson = '[["bar"],["bar"]]';
		$this->assertEquals(
				$categoriesJson,
				$this->fixture->ajaxListPlaceGroupsAction($mapId)
		);
	}


	/**
	 * @test
	 */
	public function ajaxListLocationTypesActionReturnsEmptyJsonWithEmptyMapId() {
		$emptyJson = json_encode(array());
		$this->assertEquals(
			$emptyJson,
			$this->fixture->ajaxListLocationTypesAction()
		);
	}

	/**
	 * @test
	 */
	public function ajaxListLocationTypesActionReturnsLocationTypesForMapAsJson() {
		$mapId = 1;
		$mockMap = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map',
			array(), array(), '', FALSE);
		$mockLocationType = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\LocationType',
			array(), array(), '', FALSE);
		$mockObjectStorage = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage',
			array(), array(), '', FALSE);

		$mockLocationType->expects($this->exactly(2))
			->method('toArray')
			->will($this->returnValue(array( 'bar')));
		$mockObjectStorage->expects($this->once())
			->method('toArray')
			->will($this->returnValue(array($mockLocationType, $mockLocationType)));
		$mockMap->expects($this->exactly(2))
			->method('getLocationTypes')
			->will($this->returnValue($mockObjectStorage));
		$this->fixture->_get('mapRepository')->expects($this->once())
			->method('findByUid')
			->with($mapId)
			->will($this->returnValue($mockMap));
		$locationTypesJson = '[["bar"],["bar"]]';
		$this->assertEquals(
				$locationTypesJson,
				$this->fixture->ajaxListLocationTypesAction($mapId)
		);
	}

	 /**
	 * Test for assigning variables to view
	 *
	 * @test
	 * @return void
	 */
	public function showActionAssignsVariables() {
		$mockMap = $this->getAccessibleMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map',
			array(), array(), '', FALSE
		);
		$settings = array( 'foo' => 'bar');
		$this->fixture->_set('settings', $settings);
		$this->fixture->_get('view')->expects($this->once())
			->method('assignMultiple')
			->with(
				array(
					'map' => $mockMap,
					'settings' => $settings,
					'pid' => NULL
				)
		);
		$this->fixture->showAction($mockMap);
	}

	/**
	 * @test
	 */
	public function ajaxListActionGetsSingleCategoryFromMap() {
		$settings = array(
			'mapping' => array()
		);
		$this->fixture->_set('settings', $settings);
		$map = $this->mockMapWithOneCategory();
		$mockMapRepository = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Repository\\MapRepository',
			array('findByUid'), array(), '', false
		);
		$this->fixture->injectMapRepository($mockMapRepository);
		$mockCategoryRepository = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Repository\\CategoryRepository',
			array('findChildren'), array(), '', false
		);
		$this->inject($this->fixture, 'categoryRepository', $mockCategoryRepository);
		$mockResult = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\QueryResultInterface',
			array(), array(), '', false
		);
		$mockMapRepository->expects($this->once())
			->method('findByUid')
			->will($this->returnValue($map));
		$mockCategoryRepository->expects($this->once())
			->method('findChildren')
			->will($this->returnValue($mockResult));
		$mockTreeUtility = $this->getMock(
			'Webfox\\Ajaxmap\\Utility\\TreeUtility', array('buildObjectTree', 'convertObjectTreeToArray')
		);

		$mockObjectTree = 'foo';
		$mockTreeUtility->expects($this->once())
			->method('buildObjectTree')
			->with($mockResult)
			->will($this->returnValue($mockObjectTree));

		$mockCategories = array(
			'bar' => 'baz'
		);
		$mockTreeUtility->expects($this->once())
			->method('convertObjectTreeToArray')
			->with($mockObjectTree, 'parent,pid', $settings['mapping'])
			->will($this->returnValue($mockCategories));
		$this->fixture->_set('treeUtility', $mockTreeUtility);

		$this->assertEquals(
			json_encode($mockCategories),
			$this->fixture->ajaxListCategoriesAction(1)
		);
	}
}



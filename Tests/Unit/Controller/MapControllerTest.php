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
class MapControllerTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	public function setUp() {
		$this->fixture = $this->getAccessibleMock (
			'Webfox\\Ajaxmap\\Controller\\MapController',
			array('dummy'), array(), '', FALSE);
		$this->mockObjectManager = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Object\\ObjectManager',
			array('get'), array(), '', FALSE);
		$this->fixture->_set('objectManager', $this->mockObjectManager);
		$this->mapRepository = $this->getMock(
				'\\Webfox\\Ajaxmap\\Domain\Repository\\MapRepository', array(), array(), '', FALSE
		);
		$this->regionRepository = $this->getMock(
				'\\Webfox\\Ajaxmap\\Domain\\Repository\\RegionRepository', array(), array(), '', FALSE
		);
		$this->placeRepository = $this->getMock(
				'\\Webfox\\Ajaxmap\\Domain\\Repository\\PlaceRepository', array(), array(), '', FALSE
		);
		$this->fixture->injectMapRepository($this->mapRepository);
		$this->fixture->_set('view',
				$this->getMock('TYPO3\\CMS\\Fluid\\View\\TemplateView', array(), array(), '', FALSE));

	}

	public function tearDown() {
		unset($this->fixture);
		unset($this->mockObjectManager);
		unset($this->mapRepository);
	}

	/**
	 * @test
	 */
	public function showActionReturnsEmptyJsonWhenMapIsNotSet() {
		$settings = array();
		$configurationManager = $this->getMock(
				'\\TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'
		);

		$fixture = $this->getAccessibleMock(
				'\\Webfox\\Ajaxmap\\Controller\\MapController',
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
		$mapId = 1;
		$mockMap = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map',
			array(), array(), '', FALSE);
		$mockCategory = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Category',
			array(), array(), '', FALSE);
		$mockObjectStorage = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage',
			array(), array(), '', FALSE);

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
		$categoriesJson = '[["bar"],["bar"]]';
		$this->assertEquals(
				$categoriesJson,
				$this->fixture->ajaxListCategoriesAction($mapId)
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
		$settings = array( 'foo' => 'bar');
		$this->fixture->_set('settings', $settings);
		$this->fixture->_get('view')->expects($this->once())
			->method('assignMultiple')
			->with(
				array(
					'map' => NULL,
					'settings' => $settings,
					'pid' => NULL
				)
		);
		$this->fixture->showAction($mockMap);
	}
}
?>


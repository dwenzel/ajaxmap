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
 * Test case for class DWenzel\Ajaxmap\Controller\PlaceController.
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

/**
 * Class PlaceControllerTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class PlaceControllerTest extends UnitTestCase {

	/**
	 * @var \DWenzel\Ajaxmap\Controller\PlaceController
	 */
	protected $fixture;

	/**
	 * @var \DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand
	 */
	protected $mockDemand;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $mockObjectManager;

	protected function setUp() {
		$this->fixture = $this->getAccessibleMock (
			'DWenzel\\Ajaxmap\\Controller\\PlaceController',
			array('dummy'), array(), '', false);
		$this->mockObjectManager = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Object\\ObjectManager',
			array('get'), array(), '', false);
		$this->fixture->_set('objectManager', $this->mockObjectManager);
		$this->mockDemand = $this->getMock(
			'DWenzel\\Ajaxmap\\Domain\\Model\\Dto\\PlaceDemand',
			array(), array(), '', false);
		$placeRepository = $this->getMock(
			'DWenzel\\Ajaxmap\\Domain\\Repository\\PlaceRepository', array(), array(), '', false
		);
		$this->fixture->injectPlaceRepository($placeRepository);
		$this->fixture->_set('view',
			$this->getMock('TYPO3\\CMS\\Fluid\\View\\TemplateView', array(), array(), '', false));
	}

	/**
	 * @test
	 */
	public function createDemandFromSettingsCreatesEmptyDemandFromInvalidSettings() {
		$settings = array(
			'foo' => 'bar'
		);
		$this->mockObjectManager->expects($this->once())
			->method('get')
			->will($this->returnValue($this->mockDemand));
		$this->mockDemand->expects($this->never())->method('setMap');
		$this->mockDemand->expects($this->never())->method('setLocationTypes');
		$this->mockDemand->expects($this->never())->method('setOrder');
		$this->mockDemand->expects($this->never())->method('setConstraintsConjunction');
		$this->mockDemand->expects($this->never())->method('setPlaceGroupConjunction');
		$this->mockDemand->expects($this->never())->method('setLimit');
		$this->mockDemand->expects($this->never())->method('setPlaceGroups');
		$this->fixture->createDemandFromSettings($settings);		
	}

	/**
	 * @test
	 */
	public function createDemandFromSettingsCreatesDemandFromValidSettings() {
		$settings = array(
			'map' => 1,
			'locationTypes' => '3,5,7',
			'orderBy' => 'bar',
			'orderDirection' => 'foo',
			'constraintsConjunction' => 'AND',
			'placeGroupConjunction' => 'NOR',
			'limit' => 5,
			'placeGroups' => 'baz'
		);
		$this->mockObjectManager->expects($this->any())->method('get')
			->will($this->returnValue($this->mockDemand));
		$this->mockDemand->expects($this->once())
			->method('setMap')
			->with($this->equalTo(1));
		$this->mockDemand->expects($this->once())
			->method('setLocationTypes')
			->with($this->equalTo('3,5,7'));
		$this->mockDemand->expects($this->once())
			->method('setOrder')
			->with($this->equalTo('bar|foo'));
		$this->mockDemand->expects($this->once())
			->method('setConstraintsConjunction')
			->with($this->equalTo('AND'));
		$this->mockDemand->expects($this->once())
			->method('setPlaceGroupConjunction')
			->with($this->equalTo('NOR'));
		$this->mockDemand->expects($this->once())
			->method('setLimit')
			->with($this->equalTo(5));
		$this->mockDemand->expects($this->once())
			->method('setPlaceGroups')
			->with($this->equalTo('baz'));
		$this->fixture->expects($this->any())
			->method('createDemandFromSettings')
			->will($this->returnValue($this->mockDemand));
		$this->fixture->createDemandFromSettings($settings);
	}

	 /**
	 * Test for creating correct demand call
	 *
	 * @test
	 * @return void
	 */
	public function listActionFindsDemandedPlacesByDemandFromSettings() {
		$settings = array('list' => 'foo', 'orderBy' => 'datetime');
		$mockQueryResult = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\QueryResult',
			array(), array(), '', false);
		$configurationManager = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'
		);

		$this->fixture->injectConfigurationManager($configurationManager);
		$this->fixture->_set('settings', $settings);
		$this->mockObjectManager->expects($this
			->any())
			->method('get')
			->with('DWenzel\\Ajaxmap\\Domain\\Model\\Dto\\PlaceDemand')
			->will($this
			->returnValue($this->mockDemand));
		
		$this->mockDemand->expects($this->once())->method('setOrder')->with($this->equalTo('datetime|'));

		$this->fixture->_get('placeRepository')->expects($this
			->once())
			->method('findDemanded')
			->with($this->mockDemand)->will($this->returnValue($mockQueryResult));
		$this->fixture->_get('view')->expects($this->once())
			->method('assignMultiple')
			->with(
				array(
					'places' => $mockQueryResult,
					'settings' => $settings,
					'overwriteDemand' => NULL
				)
			);
		$this->fixture->listAction();
	}

	 /**
	 * Test for creating correct demand call
	 *
	 * @test
	 * @return void
	 */
	public function ajaxShowActionFindsOneByUid() {
		$placeId = 1;
		$mockQueryResult = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\QueryResult',
			array(), array(), '', false);
		$mockPlace = $this->getMock(
			'DWenzel\\Ajaxmap\\Domain\\Model\\Place',
			array(), array(), '', false);
		$this->fixture->_get('placeRepository')->expects(
			$this->once())
			->method('findByUid')
			->will($this->returnValue($mockPlace));

		$this->fixture->ajaxShowAction($placeId);
	}

	 /**
	 * Test for assigning variables to view
	 *
	 * @test
	 * @return void
	 */
	public function showActionAssignsVariables() {
		$settings = array( 'foo' => 'bar');
		$mockPlace = $this->getMock(
			'DWenzel\\Ajaxmap\\Domain\\Model\\Place',
			array(), array(), '', false);
		$this->fixture->_set('settings', $settings);
		$this->fixture->_get('view')->expects($this->once())
			->method('assignMultiple')
			->with(
				array(
					'place' => $mockPlace,
					'settings' => $settings
				)
		);
		$this->fixture->showAction($mockPlace);
	}
}

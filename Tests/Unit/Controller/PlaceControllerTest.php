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

use DWenzel\Ajaxmap\Controller\PlaceController;
use DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

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

    /**
     * @var PlaceRepository|MockObject
     */
	protected $placeRepository;

    /**
     * @var ViewInterface|MockObject
     */
	protected $view;

	protected function setUp() {
		$this->fixture = $this->getMockBuilder(PlaceController::class)
        ->disableOriginalConstructor()
        ->setMethods(['dummy'])->getMock();
		$this->mockObjectManager = $this->getMockBuilder(ObjectManager::class)
        ->setMethods(['get'])->getMock();
		$this->inject(
		    $this->fixture,
            'objectManager',
            $this->mockObjectManager
        );

		$this->mockDemand = $this->getMockBuilder(PlaceDemand::class)
        ->getMock();
		$this->placeRepository = $this->getMockBuilder(PlaceRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
		$this->inject($this->fixture, 'placeRepository', $this->placeRepository);
		$this->view = $this->getMockBuilder(ViewInterface::class)
            ->setMethods(['assign', 'assignMultiple'])
            ->getMockForAbstractClass();
		$this->inject($this->fixture, 'view', $this->view);
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
		$this->fixture->createDemandFromSettings($settings);
	}

	 /**
	 * Test for creating correct demand call
	 *
	 * @test
	 * @return void
	 */
	public function listActionFindsDemandedPlacesByDemandFromSettings() {
		$settings = [
		    'list' => 'foo',
            'orderBy' => 'datetime',
            'orderDirection' => 'bar'
        ];
		$mockQueryResult = $this->getMockBuilder(QueryResultInterface::class)
            ->getMockForAbstractClass();
		$configurationManager = $this->getMockBuilder(ConfigurationManagerInterface::class)
            ->getMockForAbstractClass();

		$this->fixture->injectConfigurationManager($configurationManager);
		$this->inject(
		    $this->fixture,
            'settings',
            $settings
        );
		$this->mockObjectManager->expects($this
			->any())
			->method('get')
			->with('DWenzel\\Ajaxmap\\Domain\\Model\\Dto\\PlaceDemand')
			->will($this
			->returnValue($this->mockDemand));
		
		$this->mockDemand->expects($this->once())->method('setOrder')->with($this->equalTo('datetime|bar'));

		$this->placeRepository->expects($this
			->once())
			->method('findDemanded')
			->with($this->mockDemand)->will($this->returnValue($mockQueryResult));
		$this->view->expects($this->once())
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
		$mockPlace = $this->getMockBuilder(Place::class)
            ->getMock();
		$this->placeRepository->expects(
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
		$mockPlace = $this->getMockBuilder(Place::class)
            ->getMock();
		$this->inject(
		    $this->fixture,
            'settings',
            $settings
        );
		$this->view->expects($this->once())
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

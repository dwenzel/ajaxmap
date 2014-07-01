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
 * Test case for class Webfox\Ajaxmap\Controller\PlaceController.
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
class PlaceControllerTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Webfox\Ajaxmap\Controller\PlaceController
	 */
	protected $fixture;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
//	protected $objectManager;

	/**
	 * @var \Webfox\Ajaxmap\Domain\Repository\PlaceRepository
	 */
	protected $placeRepository;

	public function setUp() {
		$objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager();
			$this->fixture = $objectManager->get('Webfox\Ajaxmap\Controller\PlaceController');
		$this->placeRepository = $this->getMock(
			'\Webfox\Ajaxmap\Domain\Repository\PlaceRepository', array(), array(), '', FALSE
		);
		$this->fixture->injectPlaceRepository($this->placeRepository);
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function createDemandFromSettingsCreatesEmptyDemandFromInvalidSettings() {
		$settings = array(
			'foo' => 'bar'
		);
		$demand = new \Webfox\Ajaxmap\Domain\Model\Dto\PlaceDemand();
		
		$this->assertEquals(
			$this->fixture->createDemandFromSettings($settings),
			$demand
		);
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
			'categoryConjunction' => 'NOR',
			'limit' => 5
		);
		$demand = new \Webfox\Ajaxmap\Domain\Model\Dto\PlaceDemand();
		$demand->setMap(1);
		$demand->setOrder('bar|foo');
		$demand->setLocationTypes('3,5,7');
		$demand->setConstraintsConjunction('AND');
		$demand->setCategoryConjunction('NOR');
		$demand->setLimit(5);

		$this->assertEquals(
			$this->fixture->createDemandFromSettings($settings),
			$demand
		);
	}
	 /**
	 * Test for creating correct demand call
	 *
	 * @test
	 * @return void
	 */
	public function listActionFindsDemandedPlacesByDemandFromSettings() {
		$demand = new \Webfox\Ajaxmap\Domain\Model\Dto\PlaceDemand();
		$settings = array('list' => 'foo', 'orderBy' => 'datetime');

		$configurationManager = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'
		);

		$fixture = $this->getAccessibleMock(
			'Webfox\\Ajaxmap\\Controller\\PlaceController',
			array('createDemandFromSettings')
		);
		$fixture->injectPlaceRepository($this->placeRepository);
		$fixture->injectConfigurationManager($configurationManager);
		$fixture->setView($this->getMock('TYPO3\\CMS\\Fluid\\View\\TemplateView', array(), array(), '', FALSE));
		$fixture->_set('settings', $settings);

		$fixture->expects($this->once())->method('createDemandFromSettings')
			->will($this->returnValue($demand));

		$this->placeRepository->expects($this->once())->method('findDemanded')
			->with($demand);

		$fixture->listAction();

		// datetime must be removed
		//$this->assertEquals($fixture->_get('settings'), array('list' => 'foo'));
	}
}
?>

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
	/**
	 * @var \Webfox\Ajaxmap\Controller\MapController
	 */
	protected $fixture;

	/**
	 * Map Repository
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\MapRepository
	 */
	private $mapRepository;

	/**
	 * 
	 * @var \Webfox\Ajaxmap\Domain\Repository\PlaceRepository
	 */
	private $placeRepository;

	/**
	 *
	 * @var \Webfox\Ajaxmap\Domain\Repository\RegionRepository
	 */
	private $regionRepository;

	public function setUp() {
		//$this->fixture = new \Webfox\Ajaxmap\Controller\MapController();
		$this->fixture = $this->getAccessibleMock (
			'Webfox\\Ajaxmap\\Controller\\MapController',
			array('dummy'), array(), '', FALSE);
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
		$this->fixture->injectRegionRepository($this->regionRepository);
		$this->fixture->injectPlaceRepository($this->placeRepository);
	}

	public function tearDown() {
		unset($this->fixture);
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
		//$fixture->injectConfigurationManager($configurationManager);
		$fixture->setView($this->getMock('TYPO3CMS\\Fluid\\View\\TemplateView', array(), array(), '', FALSE));

		$fixture->expects($this->once())->method('showAction')
			->will($this->returnValue('{}'));
		$fixture->showAction();
	}

	/**
	 * @test
	 */
	public function ajaxLoadCategoriesActionReturnsEmptyJsonWithEmptyMapId() {
		$emptyJson = json_encode(array());
		$this->assertEquals(
			$emptyJson,
			$this->fixture->ajaxListCategoriesAction()
		);
	}

	/**
	 * @test
	 */
	public function ajaxLoadCategoriesActionReturnsCategoriesForMapAsJson() {
		$this->markTestIncomplete();
		/*	$mapId = 1;
		$mockMap = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Map',
			array(), array(), '', FALSE);
		$mockCategory = $this->getMock(
			'Webfox\\Ajaxmap\\Domain\\Model\\Category',
			array(), array(), '', FALSE);
		$mockCategory->expects($this->any())
			->method('toArray')
			->will($this->returnValue(array( 'bar')));
		$mockQueryResult = $this->getMock(
			'TYPO3\\CMS\\Extbase\\Persistence\\RepositoryResult',
			array(), array(), '', FALSE);
		$mockMap->expects($this->any())
			->method('getCategories')
			->will($this->returnValue(array($mockCategory)));
		$this->fixture->_get('mapRepository')->expects($this->any())
			->method('toArray')
			->will($this->returnValue(
						array($mockCategory)));
		$this->fixture->_get('mapRepository')->expects($this->once())
			->method('findByUid')
			->with($mapId)
			->will($this->returnValue($mockMap));
		//$this->fixture->ajaxListCategoriesAction(1);
		$categoriesJson = '{category: json}';
		$this->assertEquals(
				$categoriesJson,
				$this->fixture->ajaxListCategoriesAction($mapId)
		);
		*/
	}
}
?>

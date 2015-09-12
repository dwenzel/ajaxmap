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
 * Test case for class Webfox\Ajaxmap\Domain\Model\Dto\AbstractDemand.
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
 * Class AbstractDemandTest
 *
 * @package Webfox\Ajaxmap\Tests
 */
class AbstractDemandTest extends UnitTestCase {
	/**
	 * @var \Webfox\Ajaxmap\Domain\Model\Dto\AbstractDemand
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Webfox\Ajaxmap\Domain\Model\Dto\AbstractDemand();
	}

	/**
	 * @test
	 */
	public function getSearchReturnsInitialValueForDomainModelSearch() {
		$this->assertNull(
				$this->fixture->getSearch()
		);
	}

	/**
	 * @test
	 */
	public function setSearchForDomainModelSearchSetsSearch() {
		$searchObject = new \Webfox\Ajaxmap\Domain\Model\Dto\Search();
		$this->fixture->setSearch($searchObject);

		$this->assertEquals(
			$searchObject,
			$this->fixture->getSearch()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrderReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getOrder()
		);
	}

	/**
	 * @test
	 */
	public function setOrderForStringSetsOrder() { 
		$this->fixture->setOrder('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrder()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrderByAllowedReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getOrderByAllowed()
		);
	}

	/**
	 * @test
	 */
	public function setOrderByAllowedForStringSetsOrderByAllowed() { 
		$this->fixture->setOrderByAllowed('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrderByAllowed()
		);
	}
	
	/**
	 * @test
	 */
	public function getStoragePagesReturnsInitialValueForString() {
		$this->assertNull(
				$this->fixture->getStoragePages()
		);
	}

	/**
	 * @test
	 */
	public function setStoragePagesForStringSetsStoragePages() { 
		$this->fixture->setStoragePages('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getStoragePages()
		);
	}
	
	/**
	 * @test
	 */
	public function getLimitReturnsInitialValueForInteger() {
		$this->assertNull(
				$this->fixture->getLimit()
		);
	}

	/**
	 * @test
	 */
	public function setLimitForIntegerSetsLimit() { 
		$this->fixture->setLimit(100);

		$this->assertSame(
			100,
			$this->fixture->getLimit()
		);
	}
	
	/**
	 * @test
	 */
	public function getOffsetReturnsInitialValueForInteger() {
		$this->assertNull(
				$this->fixture->getOffset()
		);
	}

	/**
	 * @test
	 */
	public function setOffsetForIntegerSetsOffset() { 
		$this->fixture->setOffset(100);

		$this->assertSame(
			100,
			$this->fixture->getOffset()
		);
	}
	
	/**
	 * @test
	 */
	public function getRadiusReturnsInitialValueForInteger() {
		$this->assertNull(
				$this->fixture->getRadius()
		);
	}

	/**
	 * @test
	 */
	public function setRadiusForIntegerSetsRadius() { 
		$this->fixture->setRadius(100);

		$this->assertSame(
			100,
			$this->fixture->getRadius()
		);
	}
	
	/**
	 * @test
	 */
	public function getGeoLocationReturnsInitialValueForArray() {
		$this->assertNull(
				$this->fixture->getGeoLocation()
		);
	}

	/**
	 * @test
	 */
	public function setGeoLocationForArraySetsGeoLocation() { 
		$geoLocation = array(
			'lat' => 1.23,
			'lng' => 4.56
		);
		$this->fixture->setGeoLocation($geoLocation);

		$this->assertSame(
			$geoLocation,
			$this->fixture->getGeoLocation()
		);
	}
	
}


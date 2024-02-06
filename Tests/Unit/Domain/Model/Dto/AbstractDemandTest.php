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

use DWenzel\Ajaxmap\Domain\Model\Dto\AbstractDemand;
use DWenzel\Ajaxmap\Domain\Model\Dto\NullSearch;
use DWenzel\Ajaxmap\Domain\Model\Dto\Search;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Dto\AbstractDemand.
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

/**
 * Class AbstractDemandTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class AbstractDemandTest extends UnitTestCase
{
    /**
     * @var AbstractDemand
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new AbstractDemand();
    }

    /**
     * @test
     */
    public function getSearchReturnsInitialValueForDomainModelSearch()
    {
        $expected = new NullSearch();

        $this->assertEquals(
            $expected,
            $this->subject->getSearch()
        );
    }

    /**
     * @test
     */
    public function setSearchForDomainModelSearchSetsSearch()
    {
        $searchObject = new Search();
        $this->subject->setSearch($searchObject);

        $this->assertEquals(
            $searchObject,
            $this->subject->getSearch()
        );
    }

    /**
     * @test
     */
    public function getOrderReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getOrder()
        );
    }

    /**
     * @test
     */
    public function setOrderForStringSetsOrder()
    {
        $this->subject->setOrder('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getOrder()
        );
    }

    /**
     * @test
     */
    public function getOrderByAllowedReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getOrderByAllowed()
        );
    }

    /**
     * @test
     */
    public function setOrderByAllowedForStringSetsOrderByAllowed()
    {
        $this->subject->setOrderByAllowed('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getOrderByAllowed()
        );
    }

    /**
     * @test
     */
    public function getStoragePagesReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getStoragePages()
        );
    }

    /**
     * @test
     */
    public function setStoragePagesForStringSetsStoragePages()
    {
        $this->subject->setStoragePages('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getStoragePages()
        );
    }

    /**
     * @test
     */
    public function getLimitReturnsInitialValueForInteger()
    {
        $this->assertNull(
            $this->subject->getLimit()
        );
    }

    /**
     * @test
     */
    public function setLimitForIntegerSetsLimit()
    {
        $this->subject->setLimit(100);

        $this->assertSame(
            100,
            $this->subject->getLimit()
        );
    }

    /**
     * @test
     */
    public function getOffsetReturnsInitialValueForInteger()
    {
        $this->assertNull(
            $this->subject->getOffset()
        );
    }

    /**
     * @test
     */
    public function setOffsetForIntegerSetsOffset()
    {
        $this->subject->setOffset(100);

        $this->assertSame(
            100,
            $this->subject->getOffset()
        );
    }

    /**
     * @test
     */
    public function getRadiusReturnsInitialValueForInteger()
    {
        $this->assertNull(
            $this->subject->getRadius()
        );
    }

    /**
     * @test
     */
    public function setRadiusForIntegerSetsRadius()
    {
        $this->subject->setRadius(100);

        $this->assertSame(
            100,
            $this->subject->getRadius()
        );
    }

    /**
     * @test
     */
    public function getGeoLocationReturnsInitialValueForArray()
    {
        $this->assertNull(
            $this->subject->getGeoLocation()
        );
    }

    /**
     * @test
     */
    public function setGeoLocationForArraySetsGeoLocation()
    {
        $geoLocation = ['lat' => 1.23, 'lng' => 4.56];
        $this->subject->setGeoLocation($geoLocation);

        $this->assertSame(
            $geoLocation,
            $this->subject->getGeoLocation()
        );
    }

}


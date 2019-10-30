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
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand.
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

use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Class SearchTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class SearchTest extends UnitTestCase
{
    /**
     * @var \DWenzel\Ajaxmap\Domain\Model\Dto\Search
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new \DWenzel\Ajaxmap\Domain\Model\Dto\Search();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function getSubjectReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->fixture->getSubject()
        );
    }

    /**
     * @test
     */
    public function setSubjectForStringSetsLocationTypes()
    {
        $this->fixture->setSubject('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getSubject()
        );
    }

    /**
     * @test
     */
    public function getFieldsReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->fixture->getFields()
        );
    }

    /**
     * @test
     */
    public function setFieldsForStringSetsFields()
    {
        $this->fixture->setFields('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getFields()
        );
    }

    /**
     * @test
     */
    public function getLocationReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->fixture->getLocation()
        );
    }

    /**
     * @test
     */
    public function setLocationForStringSetsCategories()
    {
        $this->fixture->setLocation('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getLocation()
        );
    }

    /**
     * @test
     */
    public function getRadiusReturnsInitialValueForInteger()
    {
        $this->assertSame(
            0,
            $this->fixture->getRadius()
        );
    }

    /**
     * @test
     */
    public function setRadiusForIntegerSetsRadius()
    {
        $this->fixture->setRadius(123);

        $this->assertSame(
            123,
            $this->fixture->getRadius()
        );
    }

    /**
     * @test
     */
    public function getBoundsReturnsInitialNull()
    {
        $this->assertSame(
            [],
            $this->fixture->getBounds()
        );
    }

    /**
     * @test
     */
    public function setBoundsForArraySetsBounds()
    {
        $bounds = array(
            'lat' => 1.5,
            'lng' => 5.1
        );
        $this->fixture->setBounds($bounds);

        $this->assertSame(
            $bounds,
            $this->fixture->getBounds()
        );
    }

}

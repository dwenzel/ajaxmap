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

use DWenzel\Ajaxmap\Configuration\SettingsInterface;
use DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class PlaceDemandTest extends UnitTestCase
{
    /**
     * @var PlaceDemand
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new PlaceDemand();
    }

    /**
     * @test
     */
    public function getLocationTypesReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->fixture->getLocationTypes()
        );
    }

    /**
     * @test
     */
    public function setLocationTypesForStringSetsLocationTypes()
    {
        $this->fixture->setLocationTypes('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getLocationTypes()
        );
    }

    /**
     * @test
     */
    public function getConstraintsConjunctionReturnsInitialValueForString()
    {
        $this->assertSame(
            SettingsInterface::CONJUNCTION_AND,
            $this->fixture->getConstraintsConjunction()
        );
    }

    /**
     * @test
     */
    public function setConstraintsConjunctionForStringSetsConstraintsConjunction()
    {
        $this->fixture->setConstraintsConjunction('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getConstraintsConjunction()
        );
    }

    /**
     * @test
     */
    public function getPlaceGroupsReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->fixture->getPlaceGroups()
        );
    }

    /**
     * @test
     */
    public function setPlaceGroupsForStringSetsCategories()
    {
        $this->fixture->setPlaceGroups('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getPlaceGroups()
        );
    }

    /**
     * @test
     */
    public function getPlaceGroupConjunctionReturnsInitialValueForString()
    {
        $this->assertSame(
            SettingsInterface::CONJUNCTION_OR,
            $this->fixture->getPlaceGroupConjunction()
        );
    }

    /**
     * @test
     */
    public function getMapReturnsInitialValueForInteger()
    {
        $this->assertSame(
            0,
            $this->fixture->getMap()
        );
    }

    /**
     * @test
     */
    public function setMapForIntegerSetsMap()
    {
        $this->fixture->setMap(99);

        $this->assertSame(
            99,
            $this->fixture->getMap()
        );
    }


    /**
     * @test
     */
    public function setPlaceGroupConjunctionForStringSetsPlaceGroupConjunction()
    {
        $this->fixture->setPlaceGroupConjunction('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getPlaceGroupConjunction()
        );
    }

}


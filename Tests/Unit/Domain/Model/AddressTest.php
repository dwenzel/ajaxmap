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
 * Test case for class DWenzel\Ajaxmap\Domain\Model\Address.
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
 * Class AddressTest
 *
 * @package DWenzel\Ajaxmap\Tests
 */
class AddressTest extends UnitTestCase
{
    /**
     * @var \DWenzel\Ajaxmap\Domain\Model\Address
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new \DWenzel\Ajaxmap\Domain\Model\Address();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function getGenderForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getGender()
        );
    }

    /**
     * @test
     */
    public function setGenderForStringSetsGender()
    {
        $this->fixture->setGender('aloha');
        $this->assertSame(
            $this->fixture->getGender(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->fixture->setName('aloha');
        $this->assertSame(
            $this->fixture->getName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getFirstNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getFirstName()
        );
    }

    /**
     * @test
     */
    public function setFirstNameForStringSetsFirstName()
    {
        $this->fixture->setFirstName('aloha');
        $this->assertSame(
            $this->fixture->getFirstName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getMiddleNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getMiddleName()
        );
    }

    /**
     * @test
     */
    public function setMiddleNameForStringSetsMiddleName()
    {
        $this->fixture->setMiddleName('aloha');
        $this->assertSame(
            $this->fixture->getMiddleName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getLastNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getLastName()
        );
    }

    /**
     * @test
     */
    public function setLastNameForStringSetsLastName()
    {
        $this->fixture->setLastName('aloha');
        $this->assertSame(
            $this->fixture->getLastName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getTitleForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->fixture->setTitle('aloha');
        $this->assertSame(
            $this->fixture->getTitle(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getAddressForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getAddress()
        );
    }

    /**
     * @test
     */
    public function setAddressForStringSetsAddress()
    {
        $this->fixture->setAddress('aloha');
        $this->assertSame(
            $this->fixture->getAddress(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getBuildingForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getBuilding()
        );
    }

    /**
     * @test
     */
    public function setBuildingForStringSetsBuilding()
    {
        $this->fixture->setBuilding('aloha');
        $this->assertSame(
            $this->fixture->getBuilding(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getRoomForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getRoom()
        );
    }

    /**
     * @test
     */
    public function setRoomForStringSetsRoom()
    {
        $this->fixture->setRoom('aloha');
        $this->assertSame(
            $this->fixture->getRoom(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getPhoneForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getPhone()
        );
    }

    /**
     * @test
     */
    public function setPhoneForStringSetsPhone()
    {
        $this->fixture->setPhone('aloha');
        $this->assertSame(
            $this->fixture->getPhone(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getFaxForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getFax()
        );
    }

    /**
     * @test
     */
    public function setFaxForStringSetsFax()
    {
        $this->fixture->setFax('aloha');
        $this->assertSame(
            $this->fixture->getFax(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getMobileForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getMobile()
        );
    }

    /**
     * @test
     */
    public function setMobileForStringSetsMobile()
    {
        $this->fixture->setMobile('aloha');
        $this->assertSame(
            $this->fixture->getMobile(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getWwwForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getWww()
        );
    }

    /**
     * @test
     */
    public function setWwwForStringSetsWww()
    {
        $this->fixture->setWww('aloha');
        $this->assertSame(
            $this->fixture->getWww(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getSkypeForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getSkype()
        );
    }

    /**
     * @test
     */
    public function setSkypeForStringSetsSkype()
    {
        $this->fixture->setSkype('aloha');
        $this->assertSame(
            $this->fixture->getSkype(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getTwitterForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getTwitter()
        );
    }

    /**
     * @test
     */
    public function setTwitterForStringSetsTwitter()
    {
        $this->fixture->setTwitter('@aloha');
        $this->assertSame(
            $this->fixture->getTwitter(),
            '@aloha'
        );
    }

    /**
     * @test
     */
    public function setTwitterThrowsInvalidArgumentExceptionForString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->fixture->setTwitter('ping');
    }

    /**
     * @test
     */
    public function getFacebookForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getFacebook()
        );
    }

    /**
     * @test
     */
    public function setFacebookForStringSetsFacebook()
    {
        $this->fixture->setFacebook('/aloha');
        $this->assertSame(
            $this->fixture->getFacebook(),
            '/aloha'
        );
    }

    /**
     * @test
     */
    public function setFacebookThrowsInvalidArgumentExceptionForString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->fixture->setFacebook('ping');
    }

    /**
     * @test
     */
    public function getLinkedInForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getLinkedIn()
        );
    }

    /**
     * @test
     */
    public function setLinkedInForStringSetsLinkedIn()
    {
        $this->fixture->setLinkedIn('aloha');
        $this->assertSame(
            $this->fixture->getLinkedIn(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getEmailForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->fixture->setEmail('aloha');
        $this->assertSame(
            $this->fixture->getEmail(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getCompanyForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getCompany()
        );
    }

    /**
     * @test
     */
    public function setCompanyForStringSetsCompany()
    {
        $this->fixture->setCompany('aloha');
        $this->assertSame(
            $this->fixture->getCompany(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getPositionForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getPosition()
        );
    }

    /**
     * @test
     */
    public function setPositionForStringSetsPosition()
    {
        $this->fixture->setPosition('aloha');
        $this->assertSame(
            $this->fixture->getPosition(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getCityForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getCity()
        );
    }

    /**
     * @test
     */
    public function setCityForStringSetsCity()
    {
        $this->fixture->setCity('aloha');
        $this->assertSame(
            $this->fixture->getCity(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getZipForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getZip()
        );
    }

    /**
     * @test
     */
    public function setZipForStringSetsZip()
    {
        $this->fixture->setZip('aloha');
        $this->assertSame(
            $this->fixture->getZip(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getRegionForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getRegion()
        );
    }

    /**
     * @test
     */
    public function setRegionForStringSetsRegion()
    {
        $this->fixture->setRegion('aloha');
        $this->assertSame(
            $this->fixture->getRegion(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getCountryForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getCountry()
        );
    }

    /**
     * @test
     */
    public function setCountryForStringSetsCountry()
    {
        $this->fixture->setCountry('aloha');
        $this->assertSame(
            $this->fixture->getCountry(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getImageForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForStringSetsImage()
    {
        $this->fixture->setImage('aloha');
        $this->assertSame(
            $this->fixture->getImage(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getDescriptionForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->fixture->setDescription('aloha');
        $this->assertSame(
            $this->fixture->getDescription(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getBirthdayForDateTimeReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->fixture->getBirthday()
        );
    }

    /**
     * @test
     */
    public function setBirthdayForDateTimeSetsBirthday()
    {
        $dateTime = new \DateTime('now');
        $this->fixture->setBirthday($dateTime);
        $this->assertEquals(
            $this->fixture->getBirthday(),
            $dateTime
        );
    }
}


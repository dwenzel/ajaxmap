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

use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;

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
    protected $subject;

    public function setUp()
    {
        $this->subject = new \DWenzel\Ajaxmap\Domain\Model\Address();
    }

    public function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getGenderForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getGender()
        );
    }

    /**
     * @test
     */
    public function setGenderForStringSetsGender()
    {
        $this->subject->setGender('aloha');
        $this->assertSame(
            $this->subject->getGender(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('aloha');
        $this->assertSame(
            $this->subject->getName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getFirstNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getFirstName()
        );
    }

    /**
     * @test
     */
    public function setFirstNameForStringSetsFirstName()
    {
        $this->subject->setFirstName('aloha');
        $this->assertSame(
            $this->subject->getFirstName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getMiddleNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getMiddleName()
        );
    }

    /**
     * @test
     */
    public function setMiddleNameForStringSetsMiddleName()
    {
        $this->subject->setMiddleName('aloha');
        $this->assertSame(
            $this->subject->getMiddleName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getLastNameForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getLastName()
        );
    }

    /**
     * @test
     */
    public function setLastNameForStringSetsLastName()
    {
        $this->subject->setLastName('aloha');
        $this->assertSame(
            $this->subject->getLastName(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getTitleForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('aloha');
        $this->assertSame(
            $this->subject->getTitle(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getAddressForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getAddress()
        );
    }

    /**
     * @test
     */
    public function setAddressForStringSetsAddress()
    {
        $this->subject->setAddress('aloha');
        $this->assertSame(
            $this->subject->getAddress(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getBuildingForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getBuilding()
        );
    }

    /**
     * @test
     */
    public function setBuildingForStringSetsBuilding()
    {
        $this->subject->setBuilding('aloha');
        $this->assertSame(
            $this->subject->getBuilding(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getRoomForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getRoom()
        );
    }

    /**
     * @test
     */
    public function setRoomForStringSetsRoom()
    {
        $this->subject->setRoom('aloha');
        $this->assertSame(
            $this->subject->getRoom(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getPhoneForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getPhone()
        );
    }

    /**
     * @test
     */
    public function setPhoneForStringSetsPhone()
    {
        $this->subject->setPhone('aloha');
        $this->assertSame(
            $this->subject->getPhone(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getFaxForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getFax()
        );
    }

    /**
     * @test
     */
    public function setFaxForStringSetsFax()
    {
        $this->subject->setFax('aloha');
        $this->assertSame(
            $this->subject->getFax(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getMobileForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getMobile()
        );
    }

    /**
     * @test
     */
    public function setMobileForStringSetsMobile()
    {
        $this->subject->setMobile('aloha');
        $this->assertSame(
            $this->subject->getMobile(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getWwwForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getWww()
        );
    }

    /**
     * @test
     */
    public function setWwwForStringSetsWww()
    {
        $this->subject->setWww('aloha');
        $this->assertSame(
            $this->subject->getWww(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getSkypeForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getSkype()
        );
    }

    /**
     * @test
     */
    public function setSkypeForStringSetsSkype()
    {
        $this->subject->setSkype('aloha');
        $this->assertSame(
            $this->subject->getSkype(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getTwitterForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getTwitter()
        );
    }

    /**
     * @test
     */
    public function setTwitterForStringSetsTwitter()
    {
        $this->subject->setTwitter('@aloha');
        $this->assertSame(
            $this->subject->getTwitter(),
            '@aloha'
        );
    }

    /**
     * @test
     */
    public function setTwitterThrowsInvalidArgumentExceptionForString()
    {
        $this->expectException('InvalidArgumentException');
        $this->subject->setTwitter('ping');
    }

    /**
     * @test
     */
    public function getFacebookForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getFacebook()
        );
    }

    /**
     * @test
     */
    public function setFacebookForStringSetsFacebook()
    {
        $this->subject->setFacebook('/aloha');
        $this->assertSame(
            $this->subject->getFacebook(),
            '/aloha'
        );
    }

    /**
     * @test
     */
    public function setFacebookThrowsInvalidArgumentExceptionForString()
    {
        $this->expectException('InvalidArgumentException');
        $this->subject->setFacebook('ping');
    }

    /**
     * @test
     */
    public function getLinkedInForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getLinkedIn()
        );
    }

    /**
     * @test
     */
    public function setLinkedInForStringSetsLinkedIn()
    {
        $this->subject->setLinkedIn('aloha');
        $this->assertSame(
            $this->subject->getLinkedIn(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getEmailForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('aloha');
        $this->assertSame(
            $this->subject->getEmail(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getCompanyForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getCompany()
        );
    }

    /**
     * @test
     */
    public function setCompanyForStringSetsCompany()
    {
        $this->subject->setCompany('aloha');
        $this->assertSame(
            $this->subject->getCompany(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getPositionForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getPosition()
        );
    }

    /**
     * @test
     */
    public function setPositionForStringSetsPosition()
    {
        $this->subject->setPosition('aloha');
        $this->assertSame(
            $this->subject->getPosition(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getCityForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getCity()
        );
    }

    /**
     * @test
     */
    public function setCityForStringSetsCity()
    {
        $this->subject->setCity('aloha');
        $this->assertSame(
            $this->subject->getCity(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getZipForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getZip()
        );
    }

    /**
     * @test
     */
    public function setZipForStringSetsZip()
    {
        $this->subject->setZip('aloha');
        $this->assertSame(
            $this->subject->getZip(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getRegionForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getRegion()
        );
    }

    /**
     * @test
     */
    public function setRegionForStringSetsRegion()
    {
        $this->subject->setRegion('aloha');
        $this->assertSame(
            $this->subject->getRegion(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getCountryForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getCountry()
        );
    }

    /**
     * @test
     */
    public function setCountryForStringSetsCountry()
    {
        $this->subject->setCountry('aloha');
        $this->assertSame(
            $this->subject->getCountry(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getImageForStringReturnsInitiallValue()
    {
        $this->assertInstanceOf(
            ObjectStorage::class,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForStringSetsImage()
    {
        $image = new ObjectStorage();

        $this->subject->setImage($image);
        $this->assertSame(
            $image,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function getDescriptionForStringReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('aloha');
        $this->assertSame(
            $this->subject->getDescription(),
            'aloha'
        );
    }

    /**
     * @test
     */
    public function getBirthdayForDateTimeReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getBirthday()
        );
    }

    /**
     * @test
     */
    public function setBirthdayForDateTimeSetsBirthday()
    {
        $dateTime = new \DateTime('now');
        $this->subject->setBirthday($dateTime);
        $this->assertEquals(
            $this->subject->getBirthday(),
            $dateTime
        );
    }

    public function testGetGeoCoordinatesReturnsInitialValue()
    {
        $this->assertSame(
            '',
            $this->subject->getGeoCoordinates()
        );
    }

    public function testGetGeoCoordinatesReturnsConcatenatedValue()
    {
        $latitude = '1.5';
        $longitude =  '2.4';

        $this->subject->setLatitude($latitude);
        $this->subject->setLongitude($longitude);

        $expectedCoordinates = $latitude . SI::SEPARATOR_GEO_COORDINATES . $longitude;

        $this->assertSame(
            $expectedCoordinates,
            $this->subject->getGeoCoordinates()
        );

    }

    public function testGetPlaceReturnsCity()
    {
        $place = 'foo';
        $this->subject->setCity($place);

        $this->assertSame(
            $place,
            $this->subject->getPlace()
        );
    }
}


<?php

namespace DWenzel\Ajaxmap\Domain\Model;
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
 *  the Free Software Foundation; either version 3 of the License, or
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

use CPSIT\GeoLocationService\Domain\Model\GeoCodableInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\Ajaxmap\DomainObject\CategorizableInterface;
use DWenzel\Ajaxmap\DomainObject\SerializableInterface;
use TYPO3\CMS\Extbase\Annotation as Extbase;
/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Place extends AbstractEntity
	implements CategorizableInterface, GeoCodableInterface, SerializableInterface {
	use ToArrayTrait, ToJsonTrait, CategorizableTrait;
	/**
	 * Title
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $title;

	/**
	 * Enter  geo coordinates (latitude,longitude - 10.99999,51.8888)
	 *
	 * @var string
	 */
	protected $geoCoordinates;

    /**
     * Latitude
     *
     * @var float
     */
	protected $latitude = 0.0;

    /**
     * Longitude
     *
     * @var float
     */
	protected $longitude = 0.0;

    /**
     * @var float Distance
     */
	protected $distance = 0.0;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Additional info. Can be shown in info window.
	 *
	 * @var string
	 */
	protected $info;

	/**
  * Place Groups
  *
  * @var ObjectStorage<PlaceGroup>
  */
 protected $placeGroups;

	/**
  * Location Type
  *
  * @var LocationType
  */
 protected $locationType;

	/**
  * regions
  *
  * @var ObjectStorage<Region>
  */
 protected $regions;

	/**
  * Add content.
  *
  * @var ObjectStorage<Content>
  */
 protected $content;

	/**
  * Add address
  *
  * @var Address
  */
 protected $address;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->categories = new ObjectStorage();
		$this->placeGroups = new ObjectStorage();
		$this->regions = new ObjectStorage();
		$this->content = new ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
  * Adds a PlaceGroup
  *
  * @return void
  */
 public function addPlaceGroup(PlaceGroup $placeGroup) {
		$this->placeGroups->attach($placeGroup);
	}

	/**
	 * Removes a PlaceGroup
	 *
	 * @param PlaceGroup $placeGroup The PlaceGroup to be removed
	 * @return void
	 */
	public function removePlaceGroup(PlaceGroup $placeGroup) {
		$this->placeGroups->detach($placeGroup);
	}

	/**
  * Returns the placeGroups
  *
  * @return ObjectStorage<PlaceGroup> $placeGroups
  */
 public function getPlaceGroups() {
		return $this->placeGroups;
	}

	/**
  * Sets the placeGroups
  *
  * @param ObjectStorage<PlaceGroup> $placeGroups
  * @return void
  */
 public function setPlaceGroups(ObjectStorage $placeGroups) {
		$this->placeGroups = $placeGroups;
	}

	/**
  * Returns the Location Type
  *
  * @return LocationType
  */
 public function getLocationType() {
		return $this->locationType;
	}

	/**
  * Sets the Location Type
  *
  * @return void
  */
 public function setLocationType(LocationType $locationType) {
		$this->locationType = $locationType;
	}

	/**
  * Adds a Region
  *
  * @return void
  */
 public function addRegion(Region $region) {
		$this->regions->attach($region);
	}

	/**
  * Removes a Region
  *
  * @param Region $regionToRemove The Region to be removed
  * @return void
  */
 public function removeRegion(Region $regionToRemove) {
		$this->regions->detach($regionToRemove);
	}

	/**
  * Returns the regions
  *
  * @return ObjectStorage<Region> $regions
  */
 public function getRegions() {
		return $this->regions;
	}

	/**
  * Sets the regions
  *
  * @param ObjectStorage<Region> $regions
  * @return void
  */
 public function setRegions(ObjectStorage $regions) {
		$this->regions = $regions;
	}

	/**
	 * Returns the info
	 *
	 * @return string $info
	 */
	public function getInfo() {
		return $this->info;
	}

	/**
	 * Sets the info
	 *
	 * @param string $info
	 * @return void
	 */
	public function setInfo($info) {
		$this->info = $info;
	}

	/**
  * Adds a content element
  */
 public function addContent(Content $content) {
		$this->content->attach($content);
	}

	/**
  * Removes a content element
  *
  * @param Content $contentToRemove The Content to be removed
  */
 public function removeContent(Content $contentToRemove) {
		$this->content->detach($contentToRemove);
	}

	/**
  * Returns the content
  *
  * @return ObjectStorage<Content> content
  */
 public function getContent() {
		return $this->content;
	}

	/**
  * Sets the content
  *
  * @param ObjectStorage<Content> $content
  */
 public function setContent(ObjectStorage $content) {
		$this->content = $content;
	}

	/**
  * Returns the address
  *
  * @return Address $address
  */
 public function getAddress(): string {
		return $this->address;
	}

	/**
  * Sets the address
  *
  * @return void
  */
 public function setAddress(Address $address): string {
		$this->address = $address;
	}

	/**
	 * Returns the geoCoordinates
	 *
	 * @return string geoCoordinates
	 */
	public function getGeoCoordinates() {
	    if (
	        empty($this->geoCoordinates) &&
            $this->address instanceof Address &&
            !empty($this->address->getGeoCoordinates())
        ) {
	        $this->geoCoordinates = $this->address->getGeoCoordinates();
	    }
		return $this->geoCoordinates;
	}

	/**
	 * Sets the geoCoordinates
	 *
	 * @param string $geoCoordinates
	 */
	public function setGeoCoordinates($geoCoordinates) {
		$this->geoCoordinates = $geoCoordinates;
	}

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        if (empty($this->latitude)
            && $this->address instanceof Address
        )
        {
            if ($this->address->getLatitude()) {
                $this->latitude = (float)$this->address->getLatitude();
            }
        }
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = (float)$latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        if (empty($this->longitude)
            && $this->address instanceof Address
        )
        {
            if ($this->address->getLongitude()) {
                $this->longitude = (float)$this->address->getLongitude();
            }
        }
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = (float)$longitude;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @return self
     */
    public function setDistance(float $distance): self
    {
        $this->distance = $distance;
        return $this;
    }

    public function getPlace(): string
    {
        if ($this->address instanceof Address)
        {
            return $this->address->getPlace();
        }

        return '';
    }

    public function getZip(): string
    {
        if ($this->address instanceof Address) {
            return $this->address->getZip();
        }

        return '';
    }
}

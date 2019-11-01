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

use DWenzel\Ajaxmap\DomainObject\CategorizableInterface;
use DWenzel\Ajaxmap\DomainObject\SerializableInterface;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Map extends AbstractEntity
    implements SerializableInterface, CategorizableInterface
{
    use ToArrayTrait, ToJsonTrait, CategorizableTrait;

    /**
     * title
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $title;

    /**
     * type
     *
     * @var integer
     */
    protected $type;

    /**
     * width
     *
     * @var integer
     * @Extbase\Validate("NotEmpty")
     */
    protected $width;

    /**
     * height
     *
     * @var integer
     * @Extbase\Validate("NotEmpty")
     */
    protected $height;

    /**
     * Center of Map (Geo location: latitude, longitude - 10.999999,51.777777)
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $mapCenter;

    /**
     * initialZoom
     *
     * @var integer
     * @Extbase\Validate("NotEmpty")
     */
    protected $initialZoom;

    /**
     * optional Style (json Array)
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $mapStyle;

    /**
     * disable default UI
     *
     * @var boolean
     */
    protected $disableDefaultUi = false;

	/**
	 * Select items for display by category.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Category>
	 */
	protected $categories;

	/**
	 * Select items for display by placeGroups.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\PlaceGroup>
	 */
	protected $placeGroups;

	/**
	 * regions
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region>
	 */
	protected $regions;

	/**
	 * Static layers
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Region>
	 */
	protected $staticLayers;

	/**
	 * Display selected places as markers.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\Place>
	 */
	protected $places;

	/**
	 * Selected places by location type.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\Ajaxmap\Domain\Model\LocationType>
	 */
	protected $locationTypes;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->categories = new ObjectStorage();
        $this->placeGroups = new ObjectStorage();
        $this->regions = new ObjectStorage();
        $this->staticLayers = new ObjectStorage();
        $this->locationTypes = new ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the width
     *
     * @return integer $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the width
     *
     * @param integer $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Returns the height
     *
     * @return integer height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets the height
     *
     * @param integer $height
     * @return integer height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Adds a Region
     *
     * @param Region $region
     * @return void
     */
    public function addRegion(Region $region)
    {
        $this->regions->attach($region);
    }

    /**
     * Removes a Region
     *
     * @param Region $regionToRemove The Region to be removed
     * @return void
     */
    public function removeRegion(Region $regionToRemove)
    {
        $this->regions->detach($regionToRemove);
    }

    /**
     * Returns the regions
     *
     * @return ObjectStorage $regions
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Sets the regions
     *
     * @param ObjectStorage $regions
     * @return void
     */
    public function setRegions(ObjectStorage $regions)
    {
        $this->regions = $regions;
    }

    /**
     * Adds a Static Layer
     *
     * @param Region $staticLayer
     * @return void
     */
    public function addStaticLayer(Region $staticLayer)
    {
        $this->staticLayers->attach($staticLayer);
    }

    /**
     * Removes a Static Layer
     *
     * @param Region $staticLayerToRemove The Region to be removed
     * @return void
     */
    public function removeStaticLayer(Region $staticLayerToRemove)
    {
        $this->staticLayers->detach($staticLayerToRemove);
    }

    /**
     * Returns the static Layers
     *
     * @return ObjectStorage $staticLayers
     */
    public function getStaticLayers()
    {
        return $this->staticLayers;
    }

    /**
     * Sets the staticLayers
     *
     * @param ObjectStorage $staticLayers
     * @return void
     */
    public function setStaticLayers(ObjectStorage $staticLayers)
    {
        $this->staticLayers = $staticLayers;
    }

    /**
     * Returns the type
     *
     * @return integer $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param integer $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the mapStyle
     *
     * @return string $mapStyle
     */
    public function getMapStyle()
    {
        return $this->mapStyle;
    }

    /**
     * Sets the mapStyle
     *
     * @param string $mapStyle
     * @return void
     */
    public function setMapStyle($mapStyle)
    {
        $this->mapStyle = preg_replace('/(?:\s\s+|\n|\t)/', '', $mapStyle);
    }

    /**
     * Returns the initialZoom
     *
     * @return integer $initialZoom
     */
    public function getInitialZoom()
    {
        return $this->initialZoom;
    }

    /**
     * Sets the initialZoom
     *
     * @param integer $initialZoom
     * @return void
     */
    public function setInitialZoom($initialZoom)
    {
        $this->initialZoom = $initialZoom;
    }

    /**
     * Returns the boolean state of disableDefaultUi
     *
     * @return boolean disableDefaultUi
     */
    public function isDisableDefaultUi()
    {
        return $this->getDisableDefaultUI();
    }

    /**
     * Returns the disableDefaultUi
     *
     * @return boolean disableDefaultUi
     */
    public function getDisableDefaultUi()
    {
        return $this->disableDefaultUi;
    }

    /**
     * Sets the disableDefaultUi
     *
     * @param boolean $disableDefaultUi
     * @return boolean disableDefaultUi
     */
    public function setDisableDefaultUi($disableDefaultUi)
    {
        $this->disableDefaultUi = $disableDefaultUi;
    }

    /**
     * Returns the mapCenter
     *
     * @return string mapCenter
     */
    public function getMapCenter()
    {
        return $this->mapCenter;
    }

    /**
     * Sets the mapCenter
     *
     * @param string $mapCenter
     * @return string mapCenter
     */
    public function setMapCenter($mapCenter)
    {
        $this->mapCenter = $mapCenter;
    }

    /**
     * Adds a PlaceGroup
     *
     * @param PlaceGroup $placeGroup
     */
    public function addPlaceGroup(PlaceGroup $placeGroup)
    {
        $this->placeGroups->attach($placeGroup);
    }

    /**
     * Removes a PlaceGroup
     *
     * @param PlaceGroup $placeGroup The PlaceGroup to be removed
     */
    public function removePlaceGroup(PlaceGroup $placeGroup)
    {
        $this->placeGroups->detach($placeGroup);
    }

    /**
     * Returns the placeGroups
     *
     * @return ObjectStorage placeGroups
     */
    public function getPlaceGroups()
    {
        return $this->placeGroups;
    }

    /**
     * Sets the placeGroups
     *
     * @param ObjectStorage $placeGroups
     */
    public function setPlaceGroups(ObjectStorage $placeGroups)
    {
        $this->placeGroups = $placeGroups;
    }

    /**
     * Adds a LocationType
     *
     * @param \DWenzel\Ajaxmap\Domain\Model\LocationType $locationType
     * @return void
     */
    public function addLocationType(\DWenzel\Ajaxmap\Domain\Model\LocationType $locationType)
    {
        $this->locationTypes->attach($locationType);
    }

    /**
     * Removes a LocationType
     *
     * @param \DWenzel\Ajaxmap\Domain\Model\LocationType $locationTypeToRemove The LocationType to be removed
     * @return void
     */
    public function removeLocationType(\DWenzel\Ajaxmap\Domain\Model\LocationType $locationTypeToRemove)
    {
        $this->locationTypes->detach($locationTypeToRemove);
    }

    /**
     * Returns the locationTypes
     *
     * @return ObjectStorage $locationTypes
     */
    public function getLocationTypes()
    {
        return $this->locationTypes;
    }

    /**
     * Sets the locationTypes
     *
     * @param ObjectStorage $locationTypes
     * @return void
     */
    public function setLocationTypes(ObjectStorage $locationTypes)
    {
        $this->locationTypes = $locationTypes;
    }

}


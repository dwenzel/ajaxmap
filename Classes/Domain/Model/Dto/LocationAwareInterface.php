<?php
declare(strict_types=1);

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

interface LocationAwareInterface
{
    /**
     * Get Bounds
     *
     * @return array An array describing a bounding box around a geolocation
     */
    public function getBounds(): array;

    /**
     * Get location
     *
     * @return string A string describing a location
     */
    public function getLocation(): string;

    /**
     * Get radius
     *
     * @return integer The search radius in meter around the search location
     */
    public function getRadius(): int;

    /**
     * Set Bounds
     *
     * @param array $bounds
     * @return void
     */
    public function setBounds($bounds): void;

    /**
     * Set location
     *
     * @param string $location A string describing a location
     * @return void
     */
    public function setLocation($location): void;

    /**
     * Set radius
     *
     * @param integer $radius The search radius in meter
     * @return void
     */
    public function setRadius($radius): void;
}

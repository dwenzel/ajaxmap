<?php
declare(strict_types=1);

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

/**
 * Class LocationAwareTrait
 *
 * @package DWenzel\Ajaxmap\Domain\Model\Dto
 */
trait LocationAwareTrait
{
    /**
     * Search location
     *
     * @var string
     */
    protected $location = '';

    /**
     * Search radius
     *
     * @var integer
     */
    protected $radius = 0;

    /**
     * Bounding box
     *
     * @var array
     */
    protected $bounds = [];

    /**
     * Two-letter regional code
     *
     * @var string
     */
    protected $region = '';

    /**
     * Get location
     *
     * @return string A string describing a location
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Set location
     *
     * @param string $location A string describing a location
     * @return void
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * Get radius
     *
     * @return integer The search radius in meter around the search location
     */
    public function getRadius(): int
    {
        return $this->radius;
    }

    /**
     * Set radius
     *
     * @param integer $radius The search radius in meter
     * @return void
     */
    public function setRadius($radius): void
    {
        $this->radius = $radius;
    }

    /**
     * Get Bounds
     *
     * @return array An array describing a bounding box around a geolocation
     */
    public function getBounds(): array
    {
        return $this->bounds;
    }

    /**
     * Set Bounds
     *
     * @param array $bounds
     * @return void
     */
    public function setBounds($bounds): void
    {
        $this->bounds = $bounds;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }
}

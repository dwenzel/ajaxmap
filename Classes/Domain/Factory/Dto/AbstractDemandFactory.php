<?php

namespace DWenzel\Ajaxmap\Domain\Factory\Dto;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DWenzel\Ajaxmap\Traits\ObjectManagerTrait;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * Class AbstractDemandFactory
 * Abstract parent for factories creating demand objects
 *
 * @package DWenzel\Ajaxmap\Domain\Factory\Dto
 */
abstract class AbstractDemandFactory
{
    use MapPropertyTrait, SkipPropertyTrait, ObjectManagerTrait;

    /**
     * Properties which should be mapped when settings
     * are applied to demand object
     *
     * @var array
     */
    protected static $mappedProperties = [];

    /**
     * Composite properties which can not set directly
     * but have to be composed from various settings or
     * require any special logic before setting
     *
     * @var array
     */
    protected static $compositeProperties = [];

    /**
     * Returns an array of property names
     * which can not be set directly
     *
     * @return array
     */
    public function getCompositeProperties()
    {
        return static::$compositeProperties;
    }

    /**
     * Returns a map of property names: ['newName' => 'oldName]
     *
     * @return array
     */
    public function getMappedProperties()
    {
        return static::$mappedProperties;
    }

    /**
     * Applies settings on demand object
     * Concrete factory class may return custom values for
     * the $mappedProperties and $compositeProperties.
     * The $mappedProperties array allows to map legacy values from settings
     * to existing properties of the demand object.
     * Property names found in the $compositeProperties are skipped here
     * and must be set by concrete factory
     *
     * @param $demand
     * @param array $settings
     */
    public function applySettings($demand, array $settings)
    {
        foreach ($settings as $propertyName => $propertyValue) {
            if ($this->shouldSkipProperty($propertyName, $propertyValue)) {
                continue;
            }
            $this->mapPropertyName($propertyName);
            if (ObjectAccess::isPropertySettable($demand, $propertyName)) {
                ObjectAccess::setProperty($demand, $propertyName, $propertyValue);
            }
        }
    }
}

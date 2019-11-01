<?php

namespace DWenzel\Ajaxmap\Data;

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

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;

/**
 * Class ProviderFactory
 */
class ProviderFactory
{
    const PROVIDER_MAP = [
        SI::ACTION_BUILD_MAP => MapDataProvider::class,
        SI::ACTION_LIST_LOCATION_TYPES => LocationTypeDataProvider::class,
        SI::ACTION_LIST_PLACES => PlaceDataProvider::class,
        SI::ACTION_LIST_PLACE_GROUPS => PlaceGroupDataProvider::class,
        SI::ACTION_GET_ADDRESS => AddressDataProvider::class,
        SI::ACTION_LIST_CATEGORIES => CategoryDataProvider::class
    ];

    /**
     * @param string $action
     * @return DataProviderInterface
     */
    public function get(string $action): DataProviderInterface
    {
        $dataProviderClass = NullDataProvider::class;
        if (isset(static::PROVIDER_MAP[$action])) {
            $dataProviderClass = static::PROVIDER_MAP[$action];
        }

        return new $dataProviderClass();
    }

}
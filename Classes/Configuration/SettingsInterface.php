<?php

namespace DWenzel\Ajaxmap\Configuration;

use TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider;

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

/**
 * Interface SettingsInterface
 */
interface SettingsInterface
{
    public const EXTENSION_KEY = 'ajaxmap';
    public const EXTENSION_NAME = 'Ajaxmap';
    public const VENDOR_NAME = 'DWenzel';

    public const RESOURCES_PATH = 'typo3conf/ext/ajaxmap/Resources/';
    /**
     * API parameters
     */
    public const API_PARAMETER_ACTION = 'action';
    public const API_PARAMETER_MAP = 'map';
    public const API_PARAMETER_MAP_ID = 'mapId';
    public const API_PARAMETER_NO_CACHE = 'no_cache';
    public const API_PARAMETER_PLACE_ID = 'placeId';

    /**
     * Key for icon registration
     */
    public const ICON_NAME_KEY = 'name';
    public const ICON_PROVIDER_CLASS_KEY = 'iconProviderClass';
    public const ICON_OPTIONS_KEY = 'options';

    /**
     * icon identifiers
     */
    public const ICON_IDENTIFIER_LOCATION_TYPE = 'ajaxmap-location-type';
    public const ICON_IDENTIFIER_MAP = 'ajaxmap-map';
    public const ICON_IDENTIFIER_PLACE = 'ajaxmap-place';
    public const ICON_IDENTIFIER_PLACEGROUP = 'ajaxmap-place-group';
    public const ICON_IDENTIFIER_REGION = 'ajaxmap-region';

    /**
     * ajax action identifiers
     */
    public const ACTION_BUILD_MAP = 'buildMap';
    public const ACTION_GET_ADDRESS = 'getAddress';
    public const ACTION_LIST_CATEGORIES = 'listCategories';
    public const ACTION_LIST_LOCATION_TYPES = 'listLocationTypes';
    public const ACTION_LIST_PLACES = 'listPlaces';
    public const ACTION_LIST_PLACE_GROUPS = 'listPlaceGroups';

    /**
     * Icons to register via API
     */
    public const ICONS_TO_REGISTER = [
        self::ICON_IDENTIFIER_LOCATION_TYPE => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'map-marker'
            ]
        ],
        self::ICON_IDENTIFIER_MAP => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'map'
            ]
        ],
        self::ICON_IDENTIFIER_PLACE => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'map-pin'
            ]
        ],
        self::ICON_IDENTIFIER_PLACEGROUP => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'clone'
            ]
        ],
        self::ICON_IDENTIFIER_REGION => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'square'

            ]
        ],
    ];

    public const MAP_SETTINGS = [
        'id' => null,
        'map' => '',
        'regions' => '',
        'kmlLayer' => '',
        'placeGroups' => '',
        'locationTypes' => [],
        'infoWindow' => '',
        'places' => '',
        'marker' => [],
        'applicationAssetPath' => '/typo3conf/ext/ajaxmap/Resources/Public/Dist/assets/'
    ];

    public const SEPARATOR_GEO_COORDINATES = ',';

    /**
     * Cache identifiers
     */
    public const CACHE_CHILDREN = 'ajaxmap_children';
    public const CACHE_AJAX_DATA = 'ajaxmap_data';

    /**
     * Settings keys
     */
    public const LOCATION_TYPES = 'locationTypes';
    public const CONSTRAINTS_CONJUNCTION = 'constraintsConjunction';
    public const DATA = 'data';
    public const PLACE_GROUPS = 'placeGroups';
    public const ID = 'id';
    public const KEYS = 'keys';
    public const MAP = 'map';
    public const PAGE_ID = 'pageId';
    public const SEARCH = 'search';
    public const SETTINGS = 'settings';
    public const MAP_SETTINGS_KEY = 'mapSettings';
    public const SUBJECT = 'subject';
    public const FIELDS = 'fields';
    public const LOCATION = 'location';
    public const RADIUS = 'radius';
    public const BOUNDS = 'bounds';
    public const REGION = 'region';
    public const FORCE_RESULT = 'forceResult';
    public const ORDER = 'order';
    public const CONJUNCTION_AND = 'AND';
    public const CONJUNCTION_OR = 'OR';
}

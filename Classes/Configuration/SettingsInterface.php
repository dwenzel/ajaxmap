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
    const EXTENSION_KEY = 'ajaxmap';
    const EXTENSION_NAME = 'Ajaxmap';
    const VENDOR_NAME = 'DWenzel';

    const RESOURCES_PATH = 'typo3conf/ext/ajaxmap/Resources/';
    /**
     * API parameters
     */
    const API_PARAMETER_ACTION = 'action';
    const API_PARAMETER_MAP = 'map';
    const API_PARAMETER_MAP_ID = 'mapId';
    const API_PARAMETER_NO_CACHE = 'no_cache';
    const API_PARAMETER_PLACE_ID = 'placeId';

    /**
     * Key for icon registration
     */
    const ICON_NAME_KEY = 'name';
    const ICON_PROVIDER_CLASS_KEY = 'iconProviderClass';
    const ICON_OPTIONS_KEY = 'options';

    /**
     * icon identifiers
     */
    const ICON_IDENTIFIER_LOCATION_TYPE = 'ajaxmap-location-type';
    const ICON_IDENTIFIER_MAP = 'ajaxmap-map';
    const ICON_IDENTIFIER_PLACE = 'ajaxmap-place';
    const ICON_IDENTIFIER_PLACEGROUP = 'ajaxmap-place-group';
    const ICON_IDENTIFIER_REGION = 'ajaxmap-region';

    /**
     * ajax action identifiers
     */
    const ACTION_BUILD_MAP = 'buildMap';
    const ACTION_GET_ADDRESS = 'getAddress';
    const ACTION_LIST_CATEGORIES = 'listCategories';
    const ACTION_LIST_LOCATION_TYPES = 'listLocationTypes';
    const ACTION_LIST_PLACES = 'listPlaces';
    const ACTION_LIST_PLACE_GROUPS = 'listPlaceGroups';

    /**
     * Icons to register via API
     */
    const ICONS_TO_REGISTER = [
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

    const MAP_SETTINGS = [
        'id' => null,
        'map' => '',
        'regions' => '',
        'kmlLayer' => '',
        'placeGroups' => '',
        'locationTypes' => [],
        'infoWindow' => '',
        'places' => '',
        'marker' => [],
        'settings' => [
            'markerClusterer' => [
                'imagePath' => self::RESOURCES_PATH . 'Public/Icons/Cluster/m'
            ],
            'regionTree' => [
                'minExpandLevel' => 3,
                // 1=> single, 2=> multi, 3=> multi hierarchical
                'selectMode' => 3,
                'icons' => false,
                'checkbox' => true,
                'extensions' => ['filter', 'glyph'],
                'glyph' => [
                    'preset' => 'awesome4',
                    'map' => [
                        'folder' => 'fa-folder',
                        'folderOpen' => 'fa-folder-open'
                    ]
                ],
                'filter' => [
                    'autoApply' => true,
                    'mode' => 'hide'
                ]
            ],
            'categoryTree' => [
                'icons' => false,
                'extensions' => ['filter', 'glyph'],
                'glyph' => [
                    'preset' => 'awesome4',
                    'map' => [
                        'folder' => 'fa-folder',
                        'folderOpen' => 'fa-folder-open'
                    ]
                ],
                'filter' => [
                    'autoApply' => true,
                    'mode' => 'hide'
                ]
            ],
            'placeGroupTree' => [
                'checkbox' => true,
                'icons' => false,
                'extensions' => ['filter', 'glyph'],
                'glyph' => [
                    'preset' => 'awesome4',
                    'map' => [
                        'folder' => 'fa-folder',
                        'folderOpen' => 'fa-folder-open'
                    ]
                ],
                'filter' => [
                    'autoApply' => true,
                    'mode' => 'hide'
                ]
            ],
            'locationTypeTree' => [
                'checkbox' => true,
                'icons' => false,
                'selectMode' => 1,
                'extensions' => ['filter', 'glyph'],
                'glyph' => [
                    'preset' => 'awesome4',
                    'map' => [
                        'folder' => 'fa-folder',
                        'folderOpen' => 'fa-folder-open'
                    ]
                ],
                'filter' => [
                    'autoApply' => true,
                    'mode' => 'hide'
                ]
            ],
            'placesTree' => [
                'toggleInfoWindowOnSelect' => true,
                'selectMode' => 1,
                'icon' => false,
                'extensions' => ['filter'],
                'quicksearch' => true,
                'filter' => [
                    'autoApply' => true,
                    'mode' => 'hide'
                ],
                'updateFilters' => [
                    'locationType' => ['treeName' => 'ajaxMapLocationTypesTree'],
                    'categories' => ['treeName' => 'ajaxMapCategoryTree'],
                    'regions' => ['treeName' => 'ajaxMapRegionsTree', 'updateLayers' => true],
                    'placeGroups' => ['treeName' => 'ajaxMapPlaceGroupTree']
                ]
            ]
        ]
    ];

    const SEPARATOR_GEO_COORDINATES = ',';

    /**
     * Cache identifiers
     */
    const CACHE_CHILDREN = 'cache_ajaxmap_children';
    const CACHE_AJAX_DATA = 'cache_ajaxmap_data';

    /**
     * Settings keys
     */
    const LOCATION_TYPES = 'locationTypes';
    const CONSTRAINTS_CONJUNCTION = 'constraintsConjunction';
    const PLACE_GROUPS = 'placeGroups';
    const ID = 'id';
    const KEYS = 'keys';
    const MAP = 'map';
    const PAGE_ID = 'pageId';
    const SEARCH = 'search';
    const SETTINGS = 'settings';
    const MAP_SETTINGS_KEY = 'mapSettings';
    const SUBJECT = 'subject';
    const FIELDS = 'fields';
    const LOCATION = 'location';
    const RADIUS = 'radius';
    const BOUNDS = 'bounds';
    const REGION = 'region';
    const ORDER = 'order';
    const CONJUNCTION_AND = 'AND';
    const CONJUNCTION_OR = 'OR';
}

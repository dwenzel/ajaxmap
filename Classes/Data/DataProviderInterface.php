<?php

namespace DWenzel\Ajaxmap\Data;

use DWenzel\Ajaxmap\Domain\Model\Category;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Model\Region;

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
 * Interface DataProviderInterface
 */
interface DataProviderInterface
{
    public const OBJECT_TO_JSON_MAP = [
        Map::class => [
            'categories' => ['exclude' => 1],
            'pid' => ['exclude' => 1],
            'placeGroups' => ['exclude' => 1]
        ],
        Category::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key']
        ],
        Region::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'regions' => [
                'mapTo' => 'children',
                'maxDepth' => 5
            ]
        ],
        Place::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'info' => ['exclude' => 1],
            'description' => [
                'mapTo' => 'tooltip'
            ]
        ]
    ];

    public function get(array $queryParameter): array;
}
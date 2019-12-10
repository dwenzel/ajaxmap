<?php

namespace DWenzel\Ajaxmap\Data;

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Domain\Factory\Dto\PlaceDemandFactory;
use DWenzel\Ajaxmap\Domain\Model\Category;
use DWenzel\Ajaxmap\Domain\Model\Dto\AbstractDemand;
use DWenzel\Ajaxmap\Domain\Model\Dto\NullSearch;
use DWenzel\Ajaxmap\Domain\Model\LocationType;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Model\PlaceGroup;
use DWenzel\Ajaxmap\Domain\Model\Region;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

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
 * Class PlaceDataProvider
 */
class PlaceDataProvider implements DataProviderInterface, MappingAwareInterface
{
    const ALLOWED_SEARCH_PARAMS = [
        SI::RADIUS,
        SI::SUBJECT,
        SI::FIELDS,
        SI::LOCATION,
        SI::BOUNDS,
        SI::REGION,
        SI::FORCE_RESULT,
    ];

    protected $mapping = [
        Category::class => [
            'description' => ['exclude' => 1],
            'icon' => ['exclude' => 1],
            'parent' => ['exclude' => 1],
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key']
        ],
        Region::class => [
            'pid' => ['exclude' => 1],
            'regions' => [
                'mapTo' => 'children',
                'maxDepth' => 1
            ],
            'uid' => ['mapTo' => 'key']
        ],
        Place::class => [
            'content' => ['exclude' => 1],
            'description' => [
                'mapTo' => 'tooltip'
            ],
            'info' => ['exclude' => 1],
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],

        ],
        PlaceGroup::class => [
            'description' => ['exclude' => 1],
            'icon' => ['exclude' => 1],
            'parent' => ['exclude' => 1],
            'pid' => ['exclude' => 1],
            'title' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key']
        ],
        LocationType::class => [
            'description' => ['exclude' => 1],
            'icon' => ['exclude' => 1],
            'pid' => ['exclude' => 1],
            'title' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
        ],

    ];

    /**
     * @var PlaceRepository
     */
    protected $placeRepository;

    /**
     * @var PlaceDemandFactory
     */
    protected $placeDemandFactory;

    /**
     * @var MapRepository
     */
    protected $mapRepository;

    public function __construct(
        MapRepository $mapRepository = null,
        PlaceRepository $placeRepository = null,
        $mapping = null
    )
    {
        /** @var ObjectManagerInterface objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->placeRepository = $placeRepository ?: $objectManager->get(PlaceRepository::class);
        $this->mapRepository = $mapRepository ?: $objectManager->get(MapRepository::class);
        if (null !== $mapping) {
            $this->mapping = $mapping;
        }
        $this->placeDemandFactory = $objectManager->get(PlaceDemandFactory::class);
    }

    /**
     * @param array $mapping
     */
    public function setMapping(array $mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * @param array $queryParameter
     * @return array
     * @throws MissingRequestArgumentException
     * @throws InvalidQueryException
     */
    public function get(array $queryParameter = []): array
    {
        if (!isset($queryParameter['mapId'])) {
            throw  new MissingRequestArgumentException(
                'Request argument mapId missing', 1557505647
            );
        }
        $mapId = (int)$queryParameter['mapId'];
        $data = [];

        $map = $this->mapRepository->findByUid($mapId);
        if (!$map instanceof Map) {
            return $data;
        }

        $settings = $this->overrideSettings(
            $this->getSettingsFromMap($map),
            $queryParameter);

        /** @var AbstractDemand $demand */
        $demand = $this->placeDemandFactory->fromSettings($settings);
        $geoLocation = $demand->getGeoLocation() ?? [];

        // Return empty result if no valid search parameters are given
        if (
            !$demand->getSearch() instanceof NullSearch &&
            !$demand->getSearch()->isForceResult() &&
            ($demand->getSearch()->isEmpty() || !$geoLocation)
        ) {
            return $data;
        }

        /** @var QueryResult $places */
        $places = $this->placeRepository->findDemanded(
            $demand,
            true,
            null,
            false
        );
        /** @var Place $place */
        foreach ($places as $place) {
            if (is_array($geoLocation)) {
                $distance = $this->placeRepository->calculateDistance($geoLocation, $place);
                $place->setDistance($distance);
            }
            $data[] = $place->toArray(2, $this->mapping);
        }

        // @todo Find better method to provide current geo location
        $data[] = [
            'key' => '_center',
            'lat' => $geoLocation['lat'],
            'lng' => $geoLocation['lng'],
        ];

        return $data;
    }

    /**
     * Override settings with allowed query parameters
     *
     * @param array $settings
     * @param $queryParameter
     * @return array
     */
    protected function overrideSettings(array $settings, $queryParameter)
    {
        if (!empty($queryParameter[SI::SEARCH])) {
            $searchParam = $queryParameter[SI::SEARCH];
            if (is_array($searchParam)) {
                $searchSettings = [];
                foreach (static::ALLOWED_SEARCH_PARAMS as $parameter) {
                    if (!empty($searchParam[$parameter])) {
                        $searchSettings[$parameter] = $searchParam[$parameter];
                    }
                }
                $settings[SI::SEARCH] = $searchSettings;
            }
        }

        return $settings;
    }

    /**
     * @param Map $map
     * @return array
     */
    protected function getSettingsFromMap(Map $map): array
    {
        $settings = [
            SI::CONSTRAINTS_CONJUNCTION => SI::CONJUNCTION_OR
        ];

        $locationTypes = [];
        /** @var LocationType $type */
        foreach ($map->getLocationTypes()->toArray() as $type) {
            $locationTypes[] = $type->getUid();
        }
        if ((bool)$locationTypes) {
            $types = implode(',', $locationTypes);
            $settings[SI::LOCATION_TYPES] = $types;
        }

        return $settings;
    }
}

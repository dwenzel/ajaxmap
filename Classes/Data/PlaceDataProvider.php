<?php

namespace DWenzel\Ajaxmap\Data;

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Domain\Model\Category;
use DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand;
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
class PlaceDataProvider implements DataProviderInterface
{
    protected $mapping = [
        Category::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'description' => ['exclude' => 1],
            'icon' => ['exclude' => 1],
            'parent' => ['exclude' => 1]
        ],
        Region::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'regions' => [
                'mapTo' => 'children',
                'maxDepth' => 1
            ]
        ],
        Place::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'info' => ['exclude' => 1],
            'content' => ['exclude' => 1],
            'description' => [
                'mapTo' => 'tooltip'
            ]
        ],
        PlaceGroup::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'title' => ['exclude' => 1],
            'parent' => ['exclude' => 1],
            'icon' => ['exclude' => 1],
            'description' => ['exclude' => 1]
        ],
        LocationType::class => [
            'pid' => ['exclude' => 1],
            'uid' => ['mapTo' => 'key'],
            'title' => ['exclude' => 1],
            'icon' => ['exclude' => 1],
            'description' => ['exclude' => 1]
        ],

    ];

    /**
     * @var PlaceRepository
     */
    protected $placeRepository;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

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
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->placeRepository = $placeRepository ?: $this->objectManager->get(PlaceRepository::class);
        $this->mapRepository = $mapRepository ?: $this->objectManager->get(MapRepository::class);
        if (null !== $mapping) {
            $this->mapping = $mapping;
        }
    }

    /**
     * @param array $queryParameter
     * @return array
     * @throws MissingRequestArgumentException
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

        if ($map->getPlaces()) {
            $data = $map->getPlaces()->toArray();
        } else {
            $placeDemand = $this->buildPlaceDemandFromMap($map);
            /** @var QueryResult $placeObjects */
            $placeObjects = $this->placeRepository->findDemanded($placeDemand, true, NULL, false);
            /** @var Place $place */
            foreach ($placeObjects as $place) {
                $data[] = $place->toArray(2, $this->mapping);
            }
        }

        return $data;
    }

    /**
     * Builds a demand object from map properties
     *
     * @param Map $map
     * @return PlaceDemand
     */
    protected function buildPlaceDemandFromMap(Map $map)
    {
        /** @var PlaceDemand $placeDemand */
        $placeDemand = $this->objectManager->get(PlaceDemand::class);
        $placeDemand->setConstraintsConjunction('or');

        $locationTypes = array();
        /** @var LocationType $type */
        foreach ($map->getLocationTypes()->toArray() as $type) {
            $locationTypes[] = $type->getUid();
        }
        if ((bool)$locationTypes) {
            $types = implode(',', $locationTypes);
            $placeDemand->setLocationTypes($types);
        }

        return $placeDemand;
    }

}
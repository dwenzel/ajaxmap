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

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Model\PlaceGroup;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use DWenzel\Ajaxmap\Domain\Repository\PlaceGroupRepository;
use DWenzel\Ajaxmap\Utility\TreeUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class PlaceGroupDataProvider
 */
class PlaceGroupDataProvider implements DataProviderInterface
{
    protected $mapping = self::OBJECT_TO_JSON_MAP;

    /**
     * PlaceGroup Repository
     *
     * @var PlaceGroupRepository
     */
    protected $placeGroupRepository;

    /**
     * @var MapRepository
     */
    protected $mapRepository;

    /**
     * @var TreeUtility
     */
    protected $treeUtility;


    /**
     * PlaceGroupDataProvider constructor.
     * @param MapRepository|null $mapRepository
     * @param PlaceGroupRepository|null $placeGroupRepository
     * @param TreeUtility|null $treeUtility
     * @param null $mapping
     */
    public function __construct(
        MapRepository $mapRepository = null,
        PlaceGroupRepository $placeGroupRepository = null,
        TreeUtility $treeUtility = null,
        $mapping = null
    )
    {
        /** @var ObjectManagerInterface objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->mapRepository = $mapRepository ?: $objectManager->get(MapRepository::class);
        $this->placeGroupRepository = $placeGroupRepository ?: $objectManager->get(PlaceGroupRepository::class);
        $this->treeUtility = $treeUtility ?: $objectManager->get(TreeUtility::class);
        if (null !== $mapping) {
            $this->mapping = $mapping;
        }
    }


    /**
     * @param array $queryParameter
     * @return array
     * @throws MissingRequestArgumentException
     * @throws \ReflectionException
     */
    public function get(array $queryParameter): array
    {
        if (!isset($queryParameter['mapId'])) {
            throw  new MissingRequestArgumentException(
                'Request argument mapId missing', 1557505647
            );
        }
        $mapId = (int)$queryParameter['mapId'];
        $data = [];

        /** @var Map $map */
        $map = $this->mapRepository->findByUid($mapId);
        if ($map AND $map->getPlaceGroups()) {
            $placeGroupObjArray = $map->getPlaceGroups()->toArray();
            if ((bool)$placeGroupObjArray) {
                $rootIds = array();
                foreach ($placeGroupObjArray as $placeGroup) {
                    /** @var PlaceGroup $placeGroup */
                    $rootIds[] = $placeGroup->getUid();
                }
                $rootIdList = implode(',', $rootIds);
                if ($children = $this->placeGroupRepository->findChildren($rootIdList, false)) {
                    $objectTree = $this->treeUtility->buildObjectTree($children);
                    $data = $this->treeUtility->convertObjectTreeToArray(
                        $objectTree,
                        'parent,pid',
                        $this->mapping
                    );
                }
            }
        }

        return $data;
    }

}
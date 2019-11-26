<?php

namespace DWenzel\Ajaxmap\Data;

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Domain\Model\LocationType;
use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

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
 * Class LocationTypeDataProvider
 */
class LocationTypeDataProvider implements DataProviderInterface, MappingAwareInterface
{
    use MappingAwareTrait;

    /**
     * @var MapRepository
     */
    protected $mapRepository;

    /**
     * CategoryDataProvider constructor.
     * @param MapRepository|null $mapRepository
     * @param null $mapping
     */
    public function __construct(
        MapRepository $mapRepository = null,
        $mapping = null
    )
    {
        /** @var ObjectManagerInterface objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->mapRepository = $mapRepository ?: $objectManager->get(MapRepository::class);
        if (null !== $mapping) {
            $this->mapping = $mapping;
        }
    }


    /**
     * @param array $queryParameter
     * @return array
     * @throws MissingRequestArgumentException
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
        if ($map && $map->getLocationTypes()) {
            $locationTypesObjArray = $map->getLocationTypes()->toArray();
            foreach ($locationTypesObjArray as $locationType) {
                /** @var LocationType $locationType */
                $data[] = $locationType->toArray(10, $this->mapping);
            }
        }

        return $data;
    }
}

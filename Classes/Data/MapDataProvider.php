<?php

namespace DWenzel\Ajaxmap\Data;

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
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
 * Class MapDataProvider
 */
class MapDataProvider implements DataProviderInterface, MappingAwareInterface
{
    use MappingAwareTrait;

    /**
     * @var MapRepository
     */
    protected $mapRepository;

    /**
     * MapDataProvider constructor.
     * @param MapRepository|null $mapRepository
     * @param array|null $mapping
     */
    public function __construct(MapRepository $mapRepository = null, array $mapping = null)
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
    public function get(array $queryParameter = []): array
    {
        $data = [];
        if (!isset($queryParameter['mapId'])) {
            throw  new MissingRequestArgumentException(
                'Request argument mapId missing', 1_557_505_647
            );
        }
        $mapId = (int)$queryParameter['mapId'];

        $map = $this->mapRepository->findByUid($mapId);

        if ($map instanceof Map) {
            $data = $map->toArray(5, $this->mapping);
        }

        return $data;
    }

}
<?php

namespace DWenzel\Ajaxmap\Data;

use DWenzel\Ajaxmap\Controller\MissingRequestArgumentException;
use DWenzel\Ajaxmap\Domain\Model\Place;
use DWenzel\Ajaxmap\Domain\Repository\PlaceRepository;
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
 * Class AddressDataProvider
 */
class AddressDataProvider implements DataProviderInterface
{

    /**
     * @var PlaceRepository
     */
    protected $placeRepository;

    /**
     * AddressDataProvider constructor.
     * @param ObjectManagerInterface|null $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager = null
    )
    {
        if(null === $objectManager) {
            /** @var ObjectManagerInterface $objectManager */
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }
        $this->placeRepository = $objectManager->get(PlaceRepository::class);
    }

    /**
     * @param array $queryParameter
     * @return array
     * @throws MissingRequestArgumentException
     */
    public function get(array $queryParameter): array
    {
        if (!isset($queryParameter['placeId'])) {
            throw  new MissingRequestArgumentException(
                'Request argument placeId missing', 1557508026
            );
        }
        $data = [];
        $placeId = (int)$queryParameter['placeId'];

        /** @var Place $place */
        $place = $this->placeRepository->findByUid($placeId);
        if ($place) {
            $data = $place->getAddress()->toArray();
        }
        return $data;
    }
}

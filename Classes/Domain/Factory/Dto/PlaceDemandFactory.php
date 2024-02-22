<?php

namespace DWenzel\Ajaxmap\Domain\Factory\Dto;

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

use DWenzel\Ajaxmap\Domain\Model\Dto\DemandInterface;
use DWenzel\Ajaxmap\Domain\Model\Dto\PlaceDemand;
use DWenzel\Ajaxmap\Domain\Model\Dto\Search;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use DWenzel\Ajaxmap\Domain\Factory\Dto\AbstractDemandFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PlaceDemandFactory
 */
class PlaceDemandFactory extends AbstractDemandFactory implements DemandFactoryInterface
{
    /**
     * @var SearchFactory
     */
    protected $searchFactory;
    protected $demand;

    public function __construct(PlaceDemand $demand)
    {
        $this->demand = $demand;
    }

    public function injectSearchFactory(SearchFactory $searchFactory) {
        $this->searchFactory = $searchFactory;
    }

    protected static $compositeProperties = [
        SI::SEARCH
    ];

    public function fromSettings(array $settings): DemandInterface
    {
        $this->applySettings($this->demand, $settings);

        if (!empty($settings[SI::SEARCH])) {
            $this->demand->setSearch(
                $this->searchFactory->fromSettings($settings[SI::SEARCH])
            );
        }

        return $demand;
    }
}

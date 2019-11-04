<?php

namespace DWenzel\Ajaxmap\Domain\Factory\Dto;

use DWenzel\Ajaxmap\Domain\Model\Dto\Search;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel <wenzel@cps-it.de>
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
class SearchFactory
{


    /**
     * Builds a search object from settings
     *
     * @param array $settings
     * @return Search
     */
    public function fromSettings(array $settings): Search
    {
        $search = new Search();
        if (!empty($settings[SI::SUBJECT])) {
            $search->setSubject((string)$settings[SI::SUBJECT]);
        }
        if (!empty($settings[SI::FIELDS])) {
            $search->setFields((string)$settings[SI::FIELDS]);
        }
        if (!empty($settings[SI::LOCATION])) {
            $search->setLocation($settings[SI::LOCATION]);
        }
        if (!empty($settings[SI::RADIUS])) {
            $search->setRadius((int)$settings[SI::RADIUS]);
        }
        if (!empty($settings[SI::BOUNDS]) && is_array($settings[SI::BOUNDS])) {
            $search->setRadius((int)$settings[SI::BOUNDS]);
        }

        return $search;
    }
}

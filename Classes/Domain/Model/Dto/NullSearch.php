<?php

namespace DWenzel\Ajaxmap\Domain\Model\Dto;

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
 * Class NullSearch
 */
final class NullSearch extends Search
{
    /**
     * @return array
     */
    public function getBounds(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getFields(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return '';
    }

    public function getRadius(): int
    {
        return 0;
    }

    public function getSubject(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return '';
    }
}
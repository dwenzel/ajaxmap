<?php

namespace DWenzel\Ajaxmap\Tests\Unit\Domain\Model\Dto;

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

use DWenzel\Ajaxmap\Domain\Model\Dto\NullSearch;
use DWenzel\Ajaxmap\Domain\Model\Dto\Search;
use DWenzel\Ajaxmap\Domain\Model\Dto\SearchAwareDemandTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case for class \DWenzel\Ajaxmap\Domain\Model\Dto\SearchAwareDemandTrait.
 */
class SearchAwareDemandTraitTest extends UnitTestCase
{

    /**
     * @var SearchAwareDemandTrait
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getMockForTrait(SearchAwareDemandTrait::class);
    }

    /**
     * @test
     */
    public function getSearchInitiallyReturnsNull()
    {
        $this->assertInstanceOf(
            NullSearch::class,
            $this->subject->getSearch()
        );
    }

    /**
     * @test
     */
    public function setSearchForObjectSetsSearch()
    {
        $search = new Search();
        $this->subject->setSearch($search);

        $this->assertSame(
            $search,
            $this->subject->getSearch()
        );
    }
}

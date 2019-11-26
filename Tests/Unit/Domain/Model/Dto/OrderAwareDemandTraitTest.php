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

use DWenzel\Ajaxmap\Domain\Model\Dto\OrderAwareDemandTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class OrderAwareDemandTraitTest extends UnitTestCase
{
    /**
     * @var OrderAwareDemandTrait
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            OrderAwareDemandTrait::class
        );
    }

    /**
     * @test
     */
    public function getOrderInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getOrder()
        );
    }

    /**
     * @test
     */
    public function orderCanBeSet()
    {
        $order = 'foo|bar';
        $this->subject->setOrder($order);

        $this->assertSame(
            $order,
            $this->subject->getOrder()
        );
    }
}

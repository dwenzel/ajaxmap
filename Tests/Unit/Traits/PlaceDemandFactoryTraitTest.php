<?php
namespace DWenzel\Ajaxmap\Tests\Unit\Traits;

use DWenzel\Ajaxmap\Traits\PlaceDemandFactoryTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use DWenzel\Ajaxmap\Domain\Factory\Dto\PlaceDemandFactory;

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
class PlaceDemandFactoryTraitTest extends UnitTestCase
{
    /**
     * @var PlaceDemandFactoryTrait
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            PlaceDemandFactoryTrait::class
        );
    }

    public function testPlaceDemandFactoryCanBeInjected()
    {
        /** @var PlaceDemandFactory|\PHPUnit_Framework_MockObject_MockObject $placeDemandFactory */
        $placeDemandFactory = $this->getMockBuilder(PlaceDemandFactory::class)->getMock();

        $this->subject->injectPlaceDemandFactory($placeDemandFactory);

        $this->assertSame(
            $placeDemandFactory,
            $this->subject->getPlaceDemandFactory()
        );
    }
}

<?php
namespace Webfox\Ajaxmap\Tests\Unit\Domain\Model\Dto;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Webfox\Ajaxmap\Domain\Model\Dto\CategoryAwareDemandTrait;

/**
 * Test case for class \Webfox\Ajaxmap\Domain\Model\Dto\CategoryAwareDemandTrait.
 */
class CategoryAwareDemandTraitTest extends UnitTestCase {

	/**
	 * @var \Webfox\Ajaxmap\Domain\Model\Dto\CategoryAwareDemandTrait
	 */
	protected $subject;

	public function setUp() {
		$this->subject = $this->getMockForTrait(
			CategoryAwareDemandTrait::class
		);
	}

	/**
	 * @test
	 */
	public function getCategoriesReturnsInitialValueForString() {
		$this->assertNull($this->subject->getCategories());
	}

	/**
	 * @test
	 */
	public function setCategoriesForStringSetsCategory() {
		$this->subject->setCategories('foo');
		$this->assertSame(
			'foo',
			$this->subject->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function getCategoryConjunctionReturnsInitialValueForString() {
		$this->assertNull($this->subject->getCategoryConjunction());
	}

	/**
	 * @test
	 */
	public function setCategoryConjunctionForStringSetsCategory() {
		$this->subject->setCategoryConjunction('foo');
		$this->assertSame(
			'foo',
			$this->subject->getCategoryConjunction()
		);
	}
}


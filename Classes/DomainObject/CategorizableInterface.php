<?php

namespace Webfox\Ajaxmap\DomainObject;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Webfox\Ajaxmap\Domain\Model\Category;


/**
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
interface CategorizableInterface {
	/**
	 * Adds a Category
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Category $category
	 */
	public function addCategory(Category $category);

	/**
	 * Removes a Category
	 *
	 * @param \Webfox\Ajaxmap\Domain\Model\Category $category The Category to be removed
	 */
	public function removeCategory(Category $category);

	/**
	 * Returns the categories
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\Ajaxmap\Domain\Model\Category> categories
	 */
	public function getCategories();

	/**
	 * Sets the categories
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
	 */
	public function setCategories(ObjectStorage $categories);
}

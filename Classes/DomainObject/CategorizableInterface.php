<?php

namespace DWenzel\Ajaxmap\DomainObject;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\Ajaxmap\Domain\Model\Category;


/**
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
interface CategorizableInterface {
	/**
  * Adds a Category
  *
  * @param Category $category
  */
 public function addCategory(Category $category);

	/**
  * Removes a Category
  *
  * @param Category $category The Category to be removed
  */
 public function removeCategory(Category $category);

	/**
  * Returns the categories
  *
  * @return ObjectStorage<Category> categories
  */
 public function getCategories();

	/**
  * Sets the categories
  *
  * @param ObjectStorage $categories
  */
 public function setCategories(ObjectStorage $categories);
}

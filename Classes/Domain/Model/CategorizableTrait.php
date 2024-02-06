<?php
namespace DWenzel\Ajaxmap\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use DWenzel\Ajaxmap\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Dirk Wenzel <dirk.wenzel@cps-it.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
trait CategorizableTrait {

    /**
    * @var ObjectStorage<Category>
    * @Lazy
    */
    protected $categories;

    /**
    * Adds a Category
    *
    * @return void
    */
    public function addCategory(Category $category) {
		$this->categories->attach($category);
	}

    /**
    * Removes a Category
    *
    * @param Category $categoryToRemove The Category to be removed
    * @return void
    */
    public function removeCategory(Category $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}

    /**
    * Returns the categories
    *
    * @return ObjectStorage<Category> $categories
    */
    public function getCategories() {
    return $this->categories;
    }

    /**
    * Sets the categories
    *
    * @param ObjectStorage<Category> $categories
    * @return void
    */
    public function setCategories(ObjectStorage $categories) {
        $this->categories = $categories;
    }
}

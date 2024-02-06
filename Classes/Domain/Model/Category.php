<?php

namespace DWenzel\Ajaxmap\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Dirk Wenzel <dirk.wenzel@cps-it.de>
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

use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use DWenzel\Ajaxmap\DomainObject\SerializableInterface;
use TYPO3\CMS\Extbase\Domain\Model\Category as ExtbaseCategory;

/**
 * Category
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Category extends ExtbaseCategory implements TreeItemInterface, SerializableInterface {

    use ToArrayTrait, ToJsonTrait;

    /**
    * Parent
    *
    * @var \DWenzel\Ajaxmap\Domain\Model\Category|null
    * @Lazy
    */
    protected $parent = null;

	/**
	 * Gets the parent
	 *
	 * @return Category
	 */
	public function getParent() {
		if ($this->parent instanceof LazyLoadingProxy) {
			$this->parent->_loadRealInstance();
		}
		return $this->parent;
	}
}

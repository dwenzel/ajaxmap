<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
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

/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Ajaxmap_Domain_Model_Category extends Tx_Ajaxmap_DomainObject_AbstractEntity {

	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * icon
	 *
	 * @var string
	 */
	protected $icon;

	/**
	 * childCategories
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category>
	 */
	protected $childCategories;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the icon
	 *
	 * @return string $icon
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets the icon
	 *
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->childCategories = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Adds a Category
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Category $childCategory
	 * @return void
	 */
	public function addChildCategory(Tx_Ajaxmap_Domain_Model_Category $childCategory) {
		$this->childCategories->attach($childCategory);
	}

	/**
	 * Removes a Category
	 *
	 * @param Tx_Ajaxmap_Domain_Model_Category $childCategoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeChildCategory(Tx_Ajaxmap_Domain_Model_Category $childCategoryToRemove) {
		$this->childCategories->detach($childCategoryToRemove);
	}

	/**
	 * Returns the childCategories
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> $childCategories
	 */
	public function getChildCategories() {
		return $this->childCategories;
	}

	/**
	 * Sets the childCategories
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Ajaxmap_Domain_Model_Category> $childCategories
	 * @return void
	 */
	public function setChildCategories(Tx_Extbase_Persistence_ObjectStorage $childCategories) {
		$this->childCategories = $childCategories;
	}

	/**
	 * Returns the childCategories as array
	 *
	 * @param int> $treeDepth
	 * @return array
	 */
	public function getChildCategoriesArray($treeDepth = 10) {
		$childCategories = array();
		if ($this->getChildCategories() && $treeDepth>0){
			$treeDepth = $treeDepth-1;
			
			$childrenObjArray = $this->getChildCategories()->toArray();
			foreach ($childrenObjArray as $childCategory){
				$category = array(
					'key' => $childCategory->getUid(),
					'title' => $childCategory->getTitle(),
					'icon' => $childCategory->getIcon(),
					'tooltip' => $childCategory->getDescription(),
					'children' => $childCategory->getChildCategoriesArray($treeDepth),
				);
			array_push($childCategories, $category);
			}				
		}
		return $childCategories;
	}

}
?>

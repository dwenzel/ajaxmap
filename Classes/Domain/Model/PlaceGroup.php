<?php

namespace DWenzel\Ajaxmap\Domain\Model;
/***************************************************************
 *  Copyright notice
 *
 * (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 * (c) 2014 Dirk Wenzel <dirk.wenzel@cps-it.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use DWenzel\Ajaxmap\DomainObject\SerializableInterface;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Place Group
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PlaceGroup extends AbstractEntity
	implements TreeItemInterface, SerializableInterface {
	use ToArrayTrait, ToJsonTrait;

	/**
	 * Title
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
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
	 * placeGroups
	 *
	 * @var \DWenzel\Ajaxmap\Domain\Model\PlaceGroup
	 */
	protected $parent;

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
	 * Returns the parent
	 *
	 * @return \DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Sets the parent
	 *
	 * @param \DWenzel\Ajaxmap\Domain\Model\PlaceGroup $placeGroup
	 * @return void
	 */
	public function setParent(PlaceGroup $placeGroup) {
		$this->parent = $placeGroup;
	}
}


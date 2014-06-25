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
class Tx_Ajaxmap_Domain_Model_Region extends Tx_Ajaxmap_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Select KML files
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * clickable
	 *
	 * @var boolean
	 */
	protected $clickable = FALSE;

	/**
	 * suppressInfoWindows
	 *
	 * @var boolean
	 */
	protected $suppressInfoWindows = FALSE;

	/**
	 * preserveViewport
	 *
	 * @var boolean
	 */
	protected $preserveViewport = FALSE;

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
	 * Returns the file
	 *
	 * @return string $file
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Sets the file
	 *
	 * @param string $file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = $file;
	}

	/**
	 * Returns the clickable
	 *
	 * @return boolean $clickable
	 */
	public function getClickable() {
		return $this->clickable;
	}

	/**
	 * Sets the clickable
	 *
	 * @param boolean $clickable
	 * @return void
	 */
	public function setClickable($clickable) {
		$this->clickable = $clickable;
	}

	/**
	 * Returns the boolean state of clickable
	 *
	 * @return boolean
	 */
	public function isClickable() {
		return $this->getClickable();
	}

	/**
	 * Returns the suppressInfoWindows
	 *
	 * @return boolean $suppressInfoWindows
	 */
	public function getSuppressInfoWindows() {
		return $this->suppressInfoWindows;
	}

	/**
	 * Sets the suppressInfoWindows
	 *
	 * @param boolean $suppressInfoWindows
	 * @return void
	 */
	public function setSuppressInfoWindows($suppressInfoWindows) {
		$this->suppressInfoWindows = $suppressInfoWindows;
	}

	/**
	 * Returns the boolean state of suppressInfoWindows
	 *
	 * @return boolean
	 */
	public function isSuppressInfoWindows() {
		return $this->getSuppressInfoWindows();
	}

	/**
	 * Returns the preserveViewport
	 *
	 * @return boolean $preserveViewport
	 */
	public function getPreserveViewport() {
		return $this->preserveViewport;
	}

	/**
	 * Sets the preserveViewport
	 *
	 * @param boolean $preserveViewport
	 * @return void
	 */
	public function setPreserveViewport($preserveViewport) {
		$this->preserveViewport = $preserveViewport;
	}

	/**
	 * Returns the boolean state of preserveViewport
	 *
	 * @return boolean
	 */
	public function isPreserveViewport() {
		return $this->getPreserveViewport();
	}

}
?>

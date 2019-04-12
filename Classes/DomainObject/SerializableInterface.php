<?php

namespace DWenzel\Ajaxmap\DomainObject;
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
 * Serializable Interface
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
interface SerializableInterface {

	/**
	 * Return the object as array
	 *
	 * @param integer $treeDepth maximum tree depth
	 * @param array $mapping An array with keys for each model
	 * which should be mapped.
	 * @return array
	 */
	public function toArray($treeDepth = 100, $mapping = NULL);

	/**
	 * Returns a JSON Representation of the object
	 *
	 * @return string
	 */
	public function toJson();
}


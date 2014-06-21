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
//Inkludieren eines AJAX-Dispatchers aus der Extension pt_extbase aus dem TER
//Der Quellcode dieses AJAX.Dispatchers steht auch auf dem Blog von Daniel Lienert
require_once t3lib_extMgm::extPath('pt_extbase') . 'Classes/Utility/AjaxDispatcher.php';
//Connect to database
tslib_eidtools::connectDB();
 
// Init TSFE for database access
$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $TYPO3_CONF_VARS, 0, 0, true);
//var_dump($GLOBALS['TSFE']);

$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
//var_dump($GLOBALS['TSFE']->sys_page);
$GLOBALS['TSFE']->initFEuser();
$dispatcher = t3lib_div::makeInstance('Tx_PtExtbase_Utility_AjaxDispatcher'); /** @var $dispatcher Tx_PtExtbase_Utility_AjaxDispatcher */
//echo "instance of dispatcher";
//var_dump($dispatcher);

// Die folgende Zeile arbeitet mit den im AJAX-Request übergebenen Parametern und ruft eine ControllerAction auf.
// Das echo zeigt/impliziert, dass der Rückgabewert der Action den Inhalt der Response auf unseren AJAX-Requests darstellt.
echo $dispatcher->initCallArguments()->dispatch();
//echo "hello";
?>
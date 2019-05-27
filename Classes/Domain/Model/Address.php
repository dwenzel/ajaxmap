<?php

namespace DWenzel\Ajaxmap\Domain\Model;

/***************************************************************
 *  Copyright notice
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DWenzel\Ajaxmap\DomainObject\SerializableInterface;
use FriendsOfTYPO3\TtAddress\Domain\Model\Address as BaseAddress;

/**
 * Class Address
 *
 * @package DWenzel\Ajaxmap\Domain\Model
 */
class Address extends BaseAddress
    implements SerializableInterface
{
    use ToJsonTrait, ToArrayTrait;
}

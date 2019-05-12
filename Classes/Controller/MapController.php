<?php

namespace DWenzel\Ajaxmap\Controller;

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

use DWenzel\Ajaxmap\Domain\Model\Map;
use DWenzel\Ajaxmap\Domain\Repository\MapRepository;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
/**
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MapController extends AbstractController
{

    /**
     * mapRepository
     *
     * @var \DWenzel\Ajaxmap\Domain\Repository\MapRepository
     */
    protected $mapRepository;

    protected $mapSettings = SI::MAP_SETTINGS;

    /**
     * injectMapRepository
     *
     * @param \DWenzel\Ajaxmap\Domain\Repository\MapRepository $mapRepository
     * @return void
     */
    public function injectMapRepository(MapRepository $mapRepository)
    {
        $this->mapRepository = $mapRepository;
    }

    /**
     * action show
     *
     * @param \DWenzel\Ajaxmap\Domain\Model\Map $map
     * @return void
     */
    public function showAction(Map $map = NULL)
    {
        $mapId = $this->settings['map'];

        if ($map === NULL) {
            $map = $this->mapRepository->findByUid($mapId);
        }
        //should be merged with plugin settings
        $this->mapSettings['id'] = $mapId;

        $this->view->assignMultiple(
            array(
                'map' => $map,
                'mapSettings' => \json_encode($this->mapSettings),
                'settings' => $this->settings,
            )
        );
    }

}


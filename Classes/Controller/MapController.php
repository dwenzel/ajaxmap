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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class MapController
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
     * @param array $search
     * @return void
     */
    public function showAction(Map $map = null, array $search = [])
    {
        if ($map === null) {
            /** @var Map $map */
            $map = $this->mapRepository->findByUid(
                $this->settings[SI::MAP]
            );
        }
        $this->getMapSettings($search);
        $this->view->assignMultiple(
            array(
                SI::MAP => $map,
                SI::MAP_SETTINGS_KEY => \json_encode($this->mapSettings),
                SI::SETTINGS => $this->settings,
                SI::SEARCH => $search
            )
        );
    }

    /**
     * Display a search form
     * @param array $search
     */
    public function searchAction(array $search = [])
    {
        $this->view->assignMultiple(
            [
                SI::SETTINGS => $this->settings,
                SI::SEARCH => $search
            ]
        );
    }

    /**
     * @param array $search
     */
    protected function getMapSettings(array $search = []): void
    {
        $this->mapSettings[SI::ID] = $this->settings[SI::MAP];
        $this->mapSettings[SI::PAGE_ID] = $GLOBALS['TSFE']->id;
        if (empty($this->settings[SI::SEARCH])) {
            $this->settings[SI::SEARCH] = [];
        }

        if(!empty($search)) {
            $this->mapSettings[SI::SEARCH] = array_merge($this->settings[SI::SEARCH], $search);
        }
        $this->mapSettings[SI::KEYS] = $this->settings[SI::KEYS];
        $this->mapSettings = array_replace_recursive($this->mapSettings, $this->getMapSettingTypoScriptOverrides());
    }

    /**
     * @return array
     */
    protected function getMapSettingTypoScriptOverrides(): array
    {
        /** @var ObjectManager $objMgr */
        $objMgr = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ConfigurationManager $configManager */
        $configManager = $objMgr->get(ConfigurationManager::class);
        try {
            $config = $configManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        }  catch (InvalidConfigurationTypeException $e) {
            return [];
        }

        return GeneralUtility::removeDotsFromTS($config['plugin.']['tx_ajaxmap.']['settings.']['mapsettings.']??[]);
    }
}


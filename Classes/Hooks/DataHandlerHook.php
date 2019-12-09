<?php
declare(strict_types=1);
namespace DWenzel\Ajaxmap\Hooks;

/*
 * This file is part of the TYPO3 CMS extension "ajaxmap".
 *
 * Copyright (C) 2019 Elias Häußler <e.haeussler@familie-redlich.de>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * DataHandlerHook
 *
 * @author Elias Häußler <e.haeussler@familie-redlich.de>
 * @license GPL-2.0-or-later
 */
class DataHandlerHook
{
    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @var array Additional table names whose cache should be flushed
     */
    protected $tablesToFlushCaches = [
        'tt_address',
    ];

    public function __construct(CacheManager $cacheManager = null)
    {
        $this->cacheManager = $cacheManager ?? GeneralUtility::makeInstance(CacheManager::class);
    }

    /**
     * @param array $params
     * @param DataHandler $pObj
     */
    public function clearCustomCachesOnRecordSave(array $params, DataHandler &$pObj): void
    {
        $tableName = (string) $params['table'];

        if (!StringUtility::beginsWith($tableName, 'tx_ajaxmap') && !in_array($tableName, $this->tablesToFlushCaches)) {
            return;
        }

        $this->flushCache(SI::CACHE_CHILDREN);
        $this->flushCache(SI::CACHE_AJAX_DATA);
    }

    /**
     * @param string $cacheIdentifier
     * @return bool
     */
    protected function flushCache(string $cacheIdentifier): bool
    {
        try {
            $this->cacheManager->getCache($cacheIdentifier)->flush();
        } catch (NoSuchCacheException $e) {
            return false;
        }

        return true;
    }
}

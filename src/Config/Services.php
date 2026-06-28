<?php

namespace CI4Alerts\Config;

use CodeIgniter\Config\BaseService;
use CI4Alerts\Alerts;

/**
 * Services Configuration for CI4Auth
 *
 * This class registers the CI4Auth services for CodeIgniter 4.
 */
class Services extends BaseService
{
    /**
     * @param string|null $library The library config to retrieve.
     * @param bool $getShared Whether to return a shared instance.
     *
     * @return Alerts
     */
    public static function alerts(?string $library = null, bool $getShared = true)
    {
        $configObj = config('Alerts');

        if ($library === null) {
            $library = $configObj->active ?? 'bulma';
        }

        if ($getShared) {
            return static::getSharedInstance('alerts', $library);
        }

        $config = [];
        if ($configObj) {
            if (isset($configObj->config[$library]) && is_array($configObj->config[$library])) {
                $config = $configObj->config[$library];
            } elseif (isset($configObj->config) && is_array($configObj->config)) {
                // Backwards compatibility with flat config files
                $config = $configObj->config;
            }
        }

        return new Alerts($config);
    }
}

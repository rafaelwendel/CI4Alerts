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
     * Returns the authentication service instance.
     *
     * @param bool $getShared Whether to return a shared instance.
     *
     * @return Alerts
     */
    public static function alerts(bool $getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('alerts');
        }

        return new Alerts();
    }
}

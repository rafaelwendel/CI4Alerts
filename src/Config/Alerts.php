<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Alerts extends BaseConfig
{
    /**
     * Alerts configurations.
     *
     * @var array
     */
    public $config = [
        'classSucess'    => 'notification is-success',
        'classError'     => 'notification is-danger',
        'classWarning'   => 'notification is-warning',
        'sessionMsg'     => 'msg',
        'sessionMsgType' => 'msg_type',
        'template'       => '<div class="%s">%s</div>',
    ];
}

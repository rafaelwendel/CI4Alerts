<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Alerts extends BaseConfig
{
    /**
     * Active library config.
     * Supported: 'bulma', 'bootstrap', 'materialize', 'tailwind'
     *
     * @var string
     */
    public $active = 'bulma';

    /**
     * Alerts configurations.
     *
     * @var array
     */
    public $config = [
        'bulma' => [
            'classSucess'    => 'notification is-success',
            'classError'     => 'notification is-danger',
            'classWarning'   => 'notification is-warning',
            'sessionMsg'     => 'msg',
            'sessionMsgType' => 'msg_type',
            'template'       => '<div class="%s">%s</div>',
        ],
        'bootstrap' => [
            'classSucess'    => 'alert alert-success',
            'classError'     => 'alert alert-danger',
            'classWarning'   => 'alert alert-warning',
            'sessionMsg'     => 'msg',
            'sessionMsgType' => 'msg_type',
            'template'       => '<div class="%s" role="alert">%s</div>',
        ],
        'materialize' => [
            'classSucess'    => 'card-panel green lighten-4 green-text text-darken-4',
            'classError'     => 'card-panel red lighten-4 red-text text-darken-4',
            'classWarning'   => 'card-panel yellow lighten-4 yellow-text text-darken-4',
            'sessionMsg'     => 'msg',
            'sessionMsgType' => 'msg_type',
            'template'       => '<div class="%s">%s</div>',
        ],
        'tailwind' => [
            'classSucess'    => 'p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50',
            'classError'     => 'p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50',
            'classWarning'   => 'p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50',
            'sessionMsg'     => 'msg',
            'sessionMsgType' => 'msg_type',
            'template'       => '<div class="%s" role="alert">%s</div>',
        ],
    ];
}

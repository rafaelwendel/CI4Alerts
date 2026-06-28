<?php

namespace CI4Alerts;

use CodeIgniter\Session\Session;

class Alerts
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var array
     */
    protected $config = [
        'classSucess'    => 'notification is-success',
        'classError'     => 'notification is-danger',
        'classWarning'   => 'notification is-warning',
        'sessionMsg'     => 'msg',
        'sessionMsgType' => 'msg_type',
        'template'       => '<div class="%s">%s</div>',
    ];

    /**
     * Constructor.
     * 
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->session = \Config\Services::session();
        try {
            $configObj = config('Alerts');
            if ($configObj && isset($configObj->config)) {
                $this->config = array_merge($this->config, $configObj->config);
            }
        } catch (\Throwable $e) {
            // Silence configuration load errors
        }
        $this->config = array_merge($this->config, $config);
    }

    /**
     * Set an alert message in the session (flashdata).
     *
     * @param string $message Message to display.
     * @param string $type Alert type (success, error, warning).
     * @return $this
     */
    public function set(string $message, string $type = 'success')
    {
        $sessionMsgKey = $this->config['sessionMsg'] ?? 'msg';
        $sessionMsgTypeKey = $this->config['sessionMsgType'] ?? 'msg_type';

        $this->session->setFlashdata($sessionMsgKey, $message);
        $this->session->setFlashdata($sessionMsgTypeKey, $type);

        return $this;
    }

    /**
     * Set or update configuration options.
     * 
     * @param string|array $key
     * @param mixed $value
     * @return $this
     */
    public function setConfig($key, $value = null)
    {
        if (is_array($key)) {
            $this->config = array_merge($this->config, $key);
        } else {
            $this->config[$key] = $value;
        }
        return $this;
    }

    /**
     * Get a configuration option.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Display the alert message.
     * 
     * @param string|null $message Message to display. If null, retrieves from session.
     * @param string|null $type Message type (success, error, warning). If null, retrieves from session or defaults.
     * @return string HTML output or empty string
     */
    public function display(?string $message = null, ?string $type = null): string
    {
        // 1. Resolve the message
        if ($message === null) {
            $sessionMsgKey = $this->config['sessionMsg'] ?? null;
            
            // If sessionMsg config key is empty or null, we cannot fetch from session
            if (empty($sessionMsgKey)) {
                return '';
            }

            // Retrieve from flashdata (or fallback to normal session data just in case)
            $message = $this->session->getFlashdata($sessionMsgKey);
            if (empty($message)) {
                $message = $this->session->get($sessionMsgKey);
            }

            // If message is still empty/unset in the session, return empty string
            if (empty($message)) {
                return '';
            }

            // 2. Resolve the type from session if not passed as parameter
            if ($type === null) {
                $sessionMsgTypeKey = $this->config['sessionMsgType'] ?? null;
                if (!empty($sessionMsgTypeKey)) {
                    $type = $this->session->getFlashdata($sessionMsgTypeKey);
                    if (empty($type)) {
                        $type = $this->session->get($sessionMsgTypeKey);
                    }
                }
            }
        }

        // Default type if still null/empty
        if (empty($type)) {
            $type = 'success';
        }

        // Get class by type
        $cssClass = $this->getClassByType($type);

        // Get template and render
        $template = $this->config['template'] ?? '<div class="%s">%s</div>';

        // Check if template uses placeholder format (%s) or replacement format ({class}, {message})
        if (strpos($template, '%s') !== false) {
            return sprintf($template, $cssClass, $message);
        }

        return str_replace(['{class}', '{message}'], [$cssClass, $message], $template);
    }

    /**
     * Helper to get CSS class by message type.
     * 
     * @param string $type
     * @return string
     */
    protected function getClassByType(string $type): string
    {
        $type = strtolower($type);

        switch ($type) {
            case 'success':
            case 'sucess':
                // Check classSucess first as requested, then try classSuccess
                return $this->config['classSucess'] ?? $this->config['classSuccess'] ?? '';
            case 'error':
            case 'danger':
            case 'fail':
            case 'failure':
                return $this->config['classError'] ?? '';
            case 'warning':
            case 'warn':
                return $this->config['classWarning'] ?? '';
            default:
                // Fallback: check if the type name directly exists as a config key (e.g. classInfo)
                $configKey = 'class' . ucfirst($type);
                if (isset($this->config[$configKey])) {
                    return $this->config[$configKey];
                }
                return $this->config[$type] ?? '';
        }
    }

    /**
     * Helper method to output success messages directly.
     * 
     * @param string|null $message
     * @return string
     */
    public function success(?string $message = null): string
    {
        return $this->display($message, 'success');
    }

    /**
     * Helper method to output error messages directly.
     * 
     * @param string|null $message
     * @return string
     */
    public function error(?string $message = null): string
    {
        return $this->display($message, 'error');
    }

    /**
     * Helper method to output warning messages directly.
     * 
     * @param string|null $message
     * @return string
     */
    public function warning(?string $message = null): string
    {
        return $this->display($message, 'warning');
    }
}

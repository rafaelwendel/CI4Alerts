<?php

namespace CI4Alerts\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Publisher\Publisher;

/**
 * AlertsCommand Class
 *
 * Provides a CLI Spark command to publish the Alerts configuration template
 * file into the application's Config directory.
 */
class AlertsCommand extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'CI4Alerts';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'alerts:setup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Setups the CI4Alerts configuration file into app/Config';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'alerts:setup';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write(CLI::color('Starting CI4Alerts configuration setup...', 'green'));

        $source = realpath(__DIR__ . '/../Config');
        $destination = APPPATH . 'Config';

        $publisher = new Publisher($source, $destination);
        $publisher->addFiles([$source . '/Alerts.php']);
        
        try {
            if ($publisher->copy(true)) {
                CLI::write(CLI::color('File created: APPPATH\Config\Alerts.php', 'green'));
                CLI::write(CLI::color('CI4Alerts setup finished successfully.', 'green'));
            } else {
                CLI::error("Error: Failed to copy Alerts configuration file. Check write permissions in 'APPPATH/Config'.");
            }
        } catch (\Throwable $e) {
            CLI::error("Error when running alerts:setup");
            CLI::write($e->getMessage(), 'red');
        }
    }
}

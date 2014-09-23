<?php

namespace Dashbrew\Tasks;

use Dashbrew\Commands\ProvisionCommand;
use Dashbrew\Task\Task;
use Dashbrew\Util\Util;

/**
 * InitialSetup Task Class.
 *
 * @package Dashbrew\Tasks
 */
class InitialSetupTask extends Task {

    /**
     * @throws \Exception
     */
    public function run() {

        if(!$this->command instanceof ProvisionCommand){
            throw new \Exception("The Config task can only be run by the Provision command.");
        }

        $lock = '/etc/dashbrew/initial-setup.lock';
        if(file_exists($lock)){
            return;
        }

        $fs = Util::getFilesystem();
        $initial_config_file = '/vagrant/provision/main/config/config.yaml';

        $fs->copy($initial_config_file, '/vagrant/config/config.yaml', true, 'vagrant');
        $fs->copy($initial_config_file, '/vagrant/provision/main/etc/config.yaml.old', true, 'vagrant');

        $fs->mkdir(dirname($lock));
        $fs->touch($lock);
    }
}

<?php
require_once './LoggerConstants.php';
require_once './LogTarget.php';

require_once './ConsoleLogTarget.php';
require_once './FilesystemLogTarget.php';
require_once './EmailLogTarget.php';

class Logger {

    public $priorityLevels = array(
        'ERR' => LOGGER_PRIORITY_LEVEL_ERR,
        'WARNING' => LOGGER_PRIORITY_LEVEL_WARNING,
        'INFO' => LOGGER_PRIORITY_LEVEL_INFO,
        'DEBUG' => LOGGER_PRIORITY_LEVEL_DEBUG,
    );

    private $logTargets = array();

    public function __construct($configFileUrl = null) {
        if(!is_null($configFileUrl) && file_exists($configFileUrl)){
            $this->loadConfigFile($configFileUrl);
        }
    }

    public function log($string, $priority) {
        $this->output($string, $priority);
    }

    public function debug($string) {
        $this->output($string, $this->priorityLevels['DEBUG']);
    }

    public function info($string) {
        $this->output($string, $this->priorityLevels['INFO']);
    }

    public function warning($string) {
        $this->output($string, $this->priorityLevels['WARNING']);
    }

    public function warn($string) {
        $this->warning($string);
    }

    public function err($string) {
        $this->output($string, $this->priorityLevels['ERR']);
    }

    private function loadConfigFile($configFileUrl) {
        $configJson = file_get_contents($configFileUrl);
        $config = json_decode($configJson, true);
        $this->loadConfig($config);
    }

    private function loadConfig($config) {
        if(isset($config['targets'])){
            foreach($config['targets'] as $targetInfo) {
                $target = $this->createLogTarget($targetInfo);
                $this->addLogTarget($target);
            }
        }
    }

    public function addLogTarget(LogTarget $target) {
        $this->logTargets[] = $target;
    }

    private function createLogTarget($target) {
        switch($target['type']) {
            case 'email':
                return new EmailLogTarget($target['level']);
            case 'filesystem':
                return new FilesystemLogTarget($target['level']);
            default:
                return new ConsoleLogTarget($target['level']);
        }
    }

    private function output($string, $priority) {
        foreach($this->logTargets as $target) {
            if($target->getLevel() >= $priority) {
                $target->output($string);
            }
        }
    }

}
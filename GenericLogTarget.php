<?php

require_once './LoggerConstants.php';

abstract class GenericLogTarget implements LogTarget {

    protected $level = LOGGER_PRIORITY_LEVEL_DEBUG;
    protected $out = null;

    public function setLevel(int $level) : void {
        $this->level = $level;
    }

    public function getType() :string{
        return 'Generic';
    }

    public function getLevel() : int {
        return $this->level;
    }

    protected function lockOutput() {
        $this->out = fopen('php://stdout', 'w');
        flock($this->out, LOCK_EX);
    }

    protected function unlockOutput() {
        flock($this->out, LOCK_UN);
        fclose($this->out);
    }

    protected function writeOutput($message) {
        fwrite($this->out, $message);
    }

    public function output(string $message) : void {
        $this->lockOutput();
        $this->writeOutput($this->formatMessage($message));
        $this->unlockOutput();
    }

    protected function formatMessage($message) : string {
        return $this->getType() . ' TARGET: '. $message . PHP_EOL;
    }
}
<?php


interface LogTarget {
    public function getType() : string;
    public function setLevel(int $level) : void;
    public function getLevel() : int;
    public function output(string $message) : void;
}
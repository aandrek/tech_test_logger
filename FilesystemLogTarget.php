<?php

require_once './GenericLogTarget.php';

class FilesystemLogTarget extends GenericLogTarget {

    public function getType() :string{
        return 'filesystem';
    }
}
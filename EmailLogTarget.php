<?php

require_once './GenericLogTarget.php';

class EmailLogTarget extends GenericLogTarget {

    public function getType() :string{
        return 'email';
    }
}
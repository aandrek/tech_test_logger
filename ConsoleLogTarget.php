<?php

require_once './GenericLogTarget.php';

class ConsoleLogTarget extends GenericLogTarget {

    public function getType() :string{
        return 'Console';
    }

}
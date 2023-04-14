<?php
require_once 'Logger.php';

$l = new Logger();
$logTarget = new ConsoleLogTarget();
$logTarget->setLevel(LOGGER_PRIORITY_LEVEL_INFO);
$l->addLogTarget($logTarget);

//Test:
$l->debug('test 1 Shouldnt log anything');

$l->info('test 1 Should log in console!!');
$l->warn('test 1 Should log in console!!');
$l->err('test 1 Should log in console!!');



$logTargetEmail = new EmailLogTarget();
$logTargetEmail->setLevel(LOGGER_PRIORITY_LEVEL_ERR);
$l->addLogTarget($logTargetEmail);

$l->debug('test 2 Shouldnt log anything');

$l->info('test 2 Should log in console!!');
$l->warn('test 2 Should log in console!!');
$l->err('test 2 Should log in console and email!!');
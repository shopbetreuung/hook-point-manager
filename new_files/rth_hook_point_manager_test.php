<?php
use RobinTheHood\HookPointManager\Classes\HookPointManager;

include 'includes/application_top.php';
require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
restore_error_handler();
restore_exception_handler();

$hookPointManager = new HookPointManager();

$hookPointManager->registerDefault();

$hookPointManager->registerHookPoint([
    'name' => 'fw-hook-point-1',
    'module' => 'robinthehood/my-first-module',
    'file' => '/create_account.php',
    'hash' => '2b5ce65ba6177ed24c805609b28572a7',
    'line' => 30,
    'include' => '/includes/extras/create_account/befor/'
], ['2.0.4.1', '2.0.4.2', '2.0.5.1']);

$hookPointManager->registerHookPoint([
    'name' => 'fw-hook-point-2',
    'module' => 'robinthehood/my-first-module',
    'file' => '/create_account.php',
    'hash' => '//Md5 Hash der original datei unbearbeitet',
    'line' => 31,
    'include' => '/includes/extras/create_account/befor/x'
], ['2.0.4.1', '2.0.4.2', '2.0.5.1']);

$hookPointManager->registerHookPoint([
    'name' => 'fw-hook-point-fail',
    'module' => 'robinthehood/my-first-module',
    'file' => '/create_accoun.php',
    'hash' => '2b5ce65ba6177ed24c805609b28572a7',
    'line' => 31,
    'include' => '/includes/extras/create_account/befor/x'
], ['2.0.4.1', '2.0.4.2', '2.0.5.1']);

$hookPointManager->update();
var_dump($hookPointManager->getErrors());
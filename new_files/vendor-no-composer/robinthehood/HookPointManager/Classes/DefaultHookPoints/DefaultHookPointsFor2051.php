<?php
namespace RobinTheHood\HookPointManager\Classes\DefaultHookPonts;

/*
    *** Default Hook Points for Modified 2.0.5.1 ***
    You can add new hook points by making a pull request in https://github.com/RobinTheHood/hook-point-manager

    index   | description                                           | example value
    --------------------------------------------------------------------------------------------------
    name    | uniqu name of the hook point                          | hpm-default-create-account-begin
    module  | module name of hook poit creator                      | robinthehood/hook-point-manager
    file    | file path in which the hook point is to be installed  | /create_account.php
    hash    | md5-Hash of orignal unmodified file                   | 2b5ce65ba6177ed24c805609b28572a7
    line    | line after which the hook point is to be installed    | 30
    include | auto_include directory for the hook point files       | /includes/extras/create_account/begin/
 */

class DefaultHookPointsFor2051
{
    public function registerAll()
    {
        $modifiedVersions = ['2.0.5.1'];

        $hookPointManager = new HookPointManager();

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-create-account-begin',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/create_account.php',
            'hash' => '2b5ce65ba6177ed24c805609b28572a7',
            'line' => 30,
            'include' => '/includes/extras/create_account/begin/'
        ], $modifiedVersions);

    }
}
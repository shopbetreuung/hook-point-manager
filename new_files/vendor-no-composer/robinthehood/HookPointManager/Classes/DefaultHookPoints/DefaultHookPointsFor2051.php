<?php
namespace RobinTheHood\HookPointManager\Classes\DefaultHookPonts;

class DefaultHookPointsFor2051
{
    public function registerAll()
    {
        $modifiedVersions = ['2.0.5.1'];

        $hookPointManager = new HookPointManager();

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-create-account-1',
            'module' => 'robinthehood/my-first-module',
            'file' => '/create_account.php',
            'fileHash' => '// Enter md5-Hash of orignal unmodified file',
            'line' => 30,
            'include' => '/includes/extras/create_account/befor/'
        ], $modifiedVersions);

    }
}
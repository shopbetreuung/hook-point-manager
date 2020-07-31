<?php
namespace RobinTheHood\HookPointManager\Classes\DefaultHookPoints;

use RobinTheHood\HookPointManager\Classes\HookPointManager;

/*
    *** Default Hook Points for Modified 2.0.5.1 ***
    You can add new hook points by making a pull request in https://github.com/RobinTheHood/hook-point-manager

    index   | description                                           | example value
    --------------------------------------------------------------------------------------------------
    name    | unique name of the hook point                         | hpm-default-create-account-prepare-data
    module  | module name of hook poit creator                      | robinthehood/hook-point-manager
    file    | file path in which the hook point is to be installed  | /create_account.php
    hash    | md5-Hash of original unmodified file                  | 2b5ce65ba6177ed24c805609b28572a7
    line    | line after which the hook point is to be installed    | 289
    include | auto_include directory for the hook point files       | /includes/extra/hpm/create_account/prepare_data/
 */

class DefaultHookPointsFor2051
{
    public function registerAll()
    {
        $modifiedVersions = ['2.0.5.1'];

        $hookPointManager = new HookPointManager();

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-create-account-prepare-data',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/create_account.php',
            'hash' => '2b5ce65ba6177ed24c805609b28572a7',
            'line' => 289,
            'include' => '/includes/extra/hpm/create_account/prepare_data/'
        ], $modifiedVersions);


        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-create-guest-account-prepare-data',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/create_guest_account.php',
            'hash' => '1b83edb80bb28522f17bdb9715dd9d2c',
            'line' => 253,
            'include' => '/includes/extra/hpm/create_guest_account/prepare_data/'
        ], $modifiedVersions);


        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '68617ac9e3f07e2cffbb68adfd9b4d9f',
            'line' => 665,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], $modifiedVersions);


        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '68617ac9e3f07e2cffbb68adfd9b4d9f',
            'line' => 1008,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], $modifiedVersions);


        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/new_product.php',
            'hash' => 'f5bce50f35a1c99224b32cc64fbbfa3f',
            'line' => 242,
            'include' => '/admin/includes/extra/hpm/new_product/buttons/'
        ], $modifiedVersions);
        
    }
}
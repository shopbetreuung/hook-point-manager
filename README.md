# hook-point-manager
[![dicord](https://img.shields.io/discord/727190419158597683)](https://discord.gg/9NqwJqP)

Automatically creates and manages new hook points for modified shops


## How to use

In this example you can create hook points from *.../DefaultHookPoints/*. It's better to look here for a hook point or make a pull request to add a new hook point:

```php
use RobinTheHood\HookPointManager\Classes\HookPointManager;

$hookPointManager = new HookPointManager();
$hookPointManager->registerDefault();
$hookPointManager->update();
```

### Create own Hook Point
If you need a very special hook point, you can create your own with the following code:

```php
$hookPointManager = new HookPointManager();

$hookPointManager->registerHookPoint([
    'name' => 'mc-my-hook-point-name',
    'module' => 'my-company/my-first-module',
    'file' => '/create_account.php',
    'hash' => '2b5ce65ba6177ed24c805609b28572a7',
    'line' => 30,
    'include' => '/includes/extra/my-company/my-first-module/mccreate_account/'
], ['2.0.4.1', '2.0.4.2', '2.0.5.1']);
```

## Reference

### array $hookPoint
| index   | description                                          | example value                         |
|---------|------------------------------------------------------|---------------------------------------|
| name    | unique name of the hook point                        | mc-my-hook-point-name                 |
| module  | module name of hook poit creator                     | my-company/my-first-module            |
| file    | file path in which the hook point is to be installed | /create_account.php                   |
| hash    | md5-Hash of original unmodified file                 | 2b5ce65ba6177ed24c805609b28572a7      |
| line    | line after which the hook point is to be installed   | 30                                    |
| include | auto_include directory for the hook point files      | /includes/extra/.../mccreate_account/ |

### HookPointManager::registerHookPoint(array $hookPoint, array $versions)

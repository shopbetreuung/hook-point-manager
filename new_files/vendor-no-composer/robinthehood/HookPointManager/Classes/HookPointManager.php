<?php

// Robin Wieschendorf - START
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
restore_error_handler();
restore_exception_handler();
// Robin Wieschendorf - END

class HookPointManager
{

    public function registerHookPoint()
    {
        // Name
        // Description
        // Shopversion
        // Filename / Filepath
        // Line
        // Auto Include Path
    }

    public function unregisterHookPoint()
    {

    }

    public function update()
    {

    }

    //TODO: only copy when file-hash is equal
    public function createBackupFile($relativeFilePath)
    {
        $filePath = $this->getShopRoot() . $relativeFilePath;

        // if (fileHash != ...) {
        //    return;
        // }

        if (!file_exists($filePath)) {
            return;
        }

        $orgFilePath = str_replace('.php', '.hpmorg.php', $filePath);
        
        if (file_exists($orgFilePath)) {
            return;
        }
    
        copy($filePath, $orgFilePath);
    }

    public function insertHookPoints($relativeFilePath)
    {
        $filePath = $this->getShopRoot() . $relativeFilePath;
        $orgFilePath = str_replace('.php', '.hpmorg.php', $filePath);

        if (!file_exists($orgFilePath)) {
            echo $orgFilePath . ' dose not exists';
            return;
        }

        $fileContent = file_get_contents($orgFilePath);
        $lines = explode("\n", $fileContent);

        $lines = $this->arrayInsertAfter($lines, 30, '30-1', '// robinthehood/hook-point-manager:fw-hook-point-1');
        $lines = $this->arrayInsertAfter($lines, 40, '40-1', '// robinthehood/hook-point-manager:fw-hook-point-2');
        $lines = $this->arrayInsertAfter($lines, 122, '122-1', '// robinthehood/hook-point-manager:fw-hook-point-3');

        $newFileContent = implode("\n", $lines);

        file_put_contents($filePath, $newFileContent);

        var_dump($lines);
    }

    public function getShopRoot()
    {
        return realPath(__DIR__ . '/../../../../../../../../../');
    }

    public function arrayInsertAfter(array $array, $afterIndex, $newIndex, $newValue)
    {
        if (array_key_exists($afterIndex, $array)) {
            $newArray = [];
            foreach ($array as $index => $value) {
                $newArray[$index] = $value;
                if ($index === $afterIndex) {
                    $newArray[$newIndex] = $newValue;
                }
            }
            return $newArray;
        }
        return false;
    }
}

$hookPointManager = new HookPointManager();
$hookPointManager->createBackupFile('/create_account.php');
$hookPointManager->insertHookPoints('/create_account.php');
die();

// $hookPointManager->registerHookPoint([
//     'name' => 'fw-hook-point-1',
//     'versions' => ['2.0.4.1', '2.0.4.2', '2.0.5.1'],
//     'file' => '/customer_create.php',
//     'fileHash' => '//Md5 Hash der original datei unbearbeitet',
//     'line' => 11,
//     'include' => '/includes/extras/customer_create/'
// ]);

// $hookPointManager->update();
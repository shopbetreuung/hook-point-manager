<?php
namespace RobinTheHood\HookPointManager\Classes;

class HookPointManager
{

    public function registerHookPoint($hookPoint, $versions)
    {
        $hookPointRepository = new HookPointRepository();

        foreach($versions as $version) {
            if ($hookPointRepository->getHookPointByNameAndVersion($hookPoint['name'], $version)) {
                continue;
            }

            $hookPoint['version'] = $version;
            $hookPointRepository->addHookPoint($hookPoint);
        }
    }

    public function unregisterHookPoint()
    {

    }

    public function update()
    {
        $modifiedVersion = ShopInfo::getModifiedVersion();
        $hookPointRepository = new HookPointRepository();
        $hookPoints = $hookPointRepository->getAllHookPointsByVersion($modifiedVersion);

        $this->updateHookPoints($hookPoints);
    }

    public function updateHookPoints($hookPoints)
    {
        $groupHookPoints = $this->groupHookPointsByFile($hookPoints);
        foreach ($groupHookPoints as $fileHookPoints) {
            $relativeFilePath = $fileHookPoints[0]['file'];
            $this->createBackupFile($relativeFilePath);
            $this->insertHookPointsToFile($relativeFilePath, $fileHookPoints);
        }
    }

    public function groupHookPointsByFile($hookPoints)
    {
        $groupedHookPoints = [];
        foreach ($hookPoints as $hookPoint) {
            $relativeFilePath = $hookPoint['file'];
            $groupedHookPoints[$relativeFilePath][] = $hookPoint;
        }
        return $groupedHookPoints;
    }

    //TODO: only copy when file-hash is equal
    public function createBackupFile($relativeFilePath)
    {
        $filePath = ShopInfo::getShopRoot() . $relativeFilePath;

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

    public function insertHookPointsToFile($relativeFilePath, $fileHookPoints)
    {
        $filePath = ShopInfo::getShopRoot() . $relativeFilePath;
        $orgFilePath = str_replace('.php', '.hpmorg.php', $filePath);

        if (!file_exists($orgFilePath)) {
            echo $orgFilePath . ' dose not exists';
            return;
        }

        $fileContent = file_get_contents($orgFilePath);
        $lines = explode("\n", $fileContent);

        foreach($fileHookPoints as $hookPoint) {
            $name = $hookPoint['name'];
            $line = $hookPoint['line'];
            $includePath = $hookPoint['include'];
            $indexName = $line . ':' . $name;
            $lines = ArrayHelper::insertAfter($lines, $line-1, $indexName, $this->createAutoIncludeCode($name, $includePath, $orgFilePath));
        }

        $newFileContent = implode("\n", $lines);

        file_put_contents($filePath, $newFileContent);

        var_dump($lines);
    }

    public function createAutoIncludeCode($name, $includePath, $orgFilePath)
    {
        $code = "// *** robinthehood/hook-point-manager:$name START ***" . "\n";
        $code .= "// This is a automatically generated file width a new hook point." . "\n"; 
        $code .= "// You can find the original unmodified file at: $orgFilePath" . "\n"; 
        $code .= "foreach(auto_include(DIR_FS_CATALOG . '$includePath','php') as \$file) require_once (\$file);" . "\n";
        $code .= "// *** robinthehood/hook-point-manager:$name END ***" . "\n";
        return $code;
    }
}
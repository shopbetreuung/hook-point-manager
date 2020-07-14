<?php
namespace RobinTheHood\HookPointManager\Classes;

class HookPointManager
{

    protected $errors = [];

    public function registerHookPoint($hookPoint, $versions)
    {
        $hookPointRepository = new HookPointRepository();

        foreach($versions as $version) {
            $hookPoint['version'] = $version;

            if ($hookPointRepository->getHookPointByNameAndVersion($hookPoint['name'], $hookPoint['version'])) {
                $hookPointRepository->updateHookPoint($hookPoint);
            } else {
                $hookPointRepository->addHookPoint($hookPoint);
            }
        }
    }

    public function unregisterHookPoint()
    {

    }

    public function registerDefault()
    {
        (new DefaultHookPoints\DefaultHookPointsFor2051)->registerAll();
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
        $groupedHookPoints = $this->groupHookPointsByFile($hookPoints);
        
        foreach ($groupedHookPoints as $fileHookPoints) {
            $relativeFilePath = $fileHookPoints[0]['file'];
            $hash = $fileHookPoints[0]['hash'];
            $this->createBackupFile($relativeFilePath, $hash);
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
    public function createBackupFile($relativeFilePath, $hash)
    {
        $filePath = ShopInfo::getShopRoot() . $relativeFilePath;
        $orgFilePath = str_replace('.php', '.hpmorg.php', $filePath);

        if (!file_exists($filePath)) {
            //throw new \RuntimeException("Can not create original file $orgFilePath because $filePath not exsits.");
            $this->addError("Can not create original file $orgFilePath because $filePath not exsits.");
            return;
        }

        if (file_exists($orgFilePath)) {
            return;
        }
    
        if (md5(file_get_contents($filePath)) != $hash) {
            //    throw new \RuntimeException("Can not create original file $orgFilePath out of $filePath because file hash dose not match.");
            $this->addError("Can not create original file $orgFilePath out of $filePath because file hash dose not match.");
            return;
        }

        copy($filePath, $orgFilePath);
    }

    public function insertHookPointsToFile($relativeFilePath, $fileHookPoints)
    {
        $filePath = ShopInfo::getShopRoot() . $relativeFilePath;
        $orgFilePath = str_replace('.php', '.hpmorg.php', $filePath);

        if (!file_exists($orgFilePath)) {
            //throw new \RuntimeException("Can not create hook points in $filePath because $orgFilePath not exsits.");
            $this->addError("Can not create hook points in $filePath because $orgFilePath not exsits.");
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

        //var_dump($lines);
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

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
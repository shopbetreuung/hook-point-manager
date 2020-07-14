<?php
namespace RobinTheHood\HookPointManager\Classes;

class ShopInfo
{
    public static function getShopRoot(): string
    {
        return realPath(__DIR__ . '/../../../../../../../../../');
    }

    /**
     * @return string Returns the installed modified version as string.
     */
    public static function getModifiedVersion(): string
    {
        $path = self::getShopRoot() . '/admin/includes/version.php';
        if (!file_exists($path)) {
            return '';
        }

        $fileStr = file_get_contents($path);
        $pos = strpos($fileStr, 'MOD_');
        $version = substr($fileStr, (int) $pos + 4, 7);
        return $version;
    }
}
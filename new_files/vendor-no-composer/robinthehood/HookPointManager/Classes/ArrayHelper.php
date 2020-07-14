<?php
namespace RobinTheHood\HookPointManager\Classes;

class ArrayHelper
{
    public static function insertAfter(array $array, $afterIndex, $newIndex, $newValue)
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
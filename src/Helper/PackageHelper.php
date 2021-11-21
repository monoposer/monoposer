<?php

declare(strict_types=1);

namespace Monoposer\Helper;

class PackageHelper
{
    public static function getAllSubDirs(string $dirPath): array
    {
        if (!is_dir($dirPath)) {
            return [];
        }
        $arr = [];
        foreach (scandir($dirPath) as $v) {
            if ($v != '.' && $v != '..') {
                $arr[] = $v;
            }
        }
        return $arr;
    }
}

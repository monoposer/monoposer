<?php
declare(strict_types=1);

namespace Monoposer\Config;

Class PackageConfig
{
    const ROOT_DIR = ".";

    const  PACKAGE_DIR_PATH = 'packages';

    public static function getPackageDirPath(): string {
        return self::ROOT_DIR . "/" . self::PACKAGE_DIR_PATH;
    }

   
}
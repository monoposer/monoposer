<?php
declare(strict_types=1);

namespace Monoposer\Helper;

use Symfony\Component\Filesystem\Filesystem;

use Monoposer\Config\MonoposerConfig;
use Monoposer\Config\PackageConfig;

class ExtraToMonoposer
{
    protected function __construct()
    {
    }

    /**
     * @return bool
     */
    public static function WriteConfigToFile( MonoposerConfig $data ): bool
    {
        $content = [];
        foreach( $data as $key => $value ) {
            $content[$key] = $value;
        }
        $fs = new Filesystem();
        $path = PackageConfig::ROOT_DIR . "/monoposer.json";
        if( $fs->exists($path) === false ) {
            $fs->touch($path);
        }
        $fs->dumpFile( $path, json_encode( $content, JSON_UNESCAPED_SLASHES ) );
        return true;
    }
}
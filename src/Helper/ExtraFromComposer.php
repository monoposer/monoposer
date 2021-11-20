<?php
declare(strict_types=1);

namespace Monoposer\Helper;

use Symfony\Component\Filesystem\Filesystem;
use Monoposer\Config\ComposerConfig;

class ExtraFromComposer
{

    /**
     * @var ComposerConfig
     */
    private static $_instance = null;

    private $rootDir = ".";

    protected function __construct()
    {
    }

    /**
     * @return ComposerConfig
     */
    private function getConfig()
    {
        $fs = new Filesystem();
        if( $fs->exists($this->rootDir."/packages") === false ) {
            echo "composer.json is valid !!!\n";
            return new ComposerConfig();
        }
        $content = json_decode( file_get_contents($this->rootDir. '/composer.json'), true );
        $composerConfig = new ComposerConfig();
        $composerConfig->setIsHad();
        $composerConfig->setVersion( $content['version'] ?? '0.0.0' );
        return $composerConfig;
    }

    /**
     * @return ComposerConfig
     */
    public static function getContent(): ComposerConfig
    {
        if( self::$_instance == null ) {
            self::$_instance =  (new self())->getConfig();
        }
        return self::$_instance;
    }

}
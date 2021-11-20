<?php

declare(strict_types=1);

namespace Monoposer\Config;

Class ComposerConfig
{
    private  $version = "";

    private $isHad = false;

    public function setIsHad() 
    {
        $this->isHad = true;
    }

    public function getIsHad()
    {
        return $this->isHad;
    }

    public function getVersion(): string {
        return $this->version;
    }

    public function setVersion( string $version ) {
        $this->version = $version;
    }
}
<?php

declare(strict_types=1);

namespace Monoposer\Config;

final Class GithubConfig
{
    /**
     *  package-name
     */
    public  $pkgName = "";

    /**
     * repository host:  github.com
     */
    public $repoHost = "";

    /**
     * repository org: monoposer
     */
    public $repoOrg = "";

    public $branch;

    public $tag;

    public $accessToken = "";

    public $commitHash = "";

    public function getRepositoryName(): string {
        return $this->repoHost . '/' . $this->repoOrg . '/' . $this->pkgName . '.git';
    }
}
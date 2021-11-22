<?php

declare(strict_types=1);

namespace Monoposer\Helper;

use Monoposer\Config\GithubConfig;

class ConfigHelper
{
    const DEFAULT_BRANCH = 'main';

    public static function getConfig(): GithubConfig{
        $prefix = 'INPUT_';
        $config = new GithubConfig();
        $config->pkgName = getenv( $prefix . 'PKG_NAME');
        $config->repoHost = getenv( $prefix . 'REPO_HOST');
        $config->repoOrg = getenv( $prefix . 'REPO_ORG');
        $config->branch = getenv( $prefix . 'BRANCH') ?? ConfigHelper::DEFAULT_BRANCH;
        $config->tag = getenv( $prefix . 'TAG');
        $config->commitHash = getenv('GITHUB_SHA');
        $config->accessToken = getenv('GITHUB_TOKEN');
        
        return $config;
    }
}

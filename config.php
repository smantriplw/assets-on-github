<?php
require_once 'env.util.php';

class Config {
    public static $GITHUB_API_BASE_URL    = 'https://api.github.com';
    public static $GITHUB_TOKEN           = '';
    public static $GITHUB_USERNAME        = 'smantriplw';
    public static $GITHUB_REPOSITORY      = 'assets_git';
}

Config::$GITHUB_TOKEN = getenv('GITHUB_TOKEN');

// checks
PhpEnvUtil::ensureExists('GITHUB_TOKEN', Config::$GITHUB_TOKEN);

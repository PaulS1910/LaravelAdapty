<?php

namespace PS\LaravelAdapty\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use PS\LaravelAdapty\Providers\AdaptyServiceProvider;

abstract class TestCase extends Orchestra
{
    protected const API_KEY = 'secret_test_key';

    protected const BASE_URL = 'https://api.adapty.io/api/v2/server-side-api/';

    protected function getPackageProviders($app): array
    {
        return [AdaptyServiceProvider::class];
    }

    /**
     * Mirrors the configuration production runs with: a published config/adapty.php
     * where the key is stored under `secret_token` and base_url points to api.adapty.io.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('adapty.secret_token', self::API_KEY);
        $app['config']->set('adapty.base_url', self::BASE_URL);
    }
}

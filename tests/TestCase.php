<?php

namespace Blood72\Riot\Tests;

use Blood72\Riot\RiotEloquentServiceProvider;
use Orchestra\Testbench\TestCase as BaseCase;

abstract class TestCase extends BaseCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [RiotEloquentServiceProvider::class];
    }
}

<?php

declare(strict_types=1);

namespace Taecel\Taecel\Tests;

use Taecel\Taecel\TaecelServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setup(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('logging.default', 'stack');
        $app['config']->set('logging.channels.single.path', __DIR__.'/../logs/laravel.log');
    }

    protected function getPackageProviders($app)
    {
        return [TaecelServiceProvider::class];
    }
}

<?php

namespace Gabievi\LaravelSMSOffice\Tests;

use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;
use Gabievi\LaravelSMSOffice\SMSOffice;
use Gabievi\LaravelSMSOffice\SMSOfficeServiceProvider;
use Gabievi\LaravelSMSOffice\Exceptions\InvalidConfiguration;

class SMSOfficeServiceProviderTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|Container
     */
    protected $app;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = Container::getInstance();

        $this->app->singleton('config', Config::class);
    }

    /** @test */
    public function it_binds_service_provider_to_container()
    {
        $this->app['config']->set('services.smsoffice', [
            'key'    => 'TEST_KEY',
            'sender' => 'JOHN',
        ]);

        (new SMSOfficeServiceProvider($this->app))->boot();

        $this->assertArrayHasKey(SMSOffice::class, $this->app->getBindings());
    }

    /** @test */
    public function it_throws_exception_if_config_was_not_found()
    {
        $this->expectException(InvalidConfiguration::class);

        (new SMSOfficeServiceProvider($this->app))->boot();
    }
}

class Config
{
    protected $storage = [];

    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->storage)) {
            return $this->storage[$key];
        }

        return $default;
    }

    public function set($key, $value)
    {
        $this->storage[$key] = $value;
    }
}

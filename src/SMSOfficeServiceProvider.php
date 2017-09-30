<?php

namespace Gabievi\LaravelSMSOffice;

use Illuminate\Support\ServiceProvider;
use Gabievi\LaravelSMSOffice\Exceptions\InvalidConfiguration;

class SMSOfficeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     * @throws InvalidConfiguration
     */
    public function boot()
    {
        $config = config('services.smsoffice');

        throw_unless($config, InvalidConfiguration::class);

        $this->app->singleton(SMSOffice::class, function () use ($config) {
            return new SMSOffice($config['key'], $config['sender']);
        });
    }
}

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
     */
    public function boot()
    {
        $this->app->singleton(SMSOffice::class, function () {
            $config = config('services.smsoffice');

            if ($config === null) {
                throw new InvalidConfiguration;
            }

            return new SMSOffice($config['key'], $config['sender']);
        });
    }
}
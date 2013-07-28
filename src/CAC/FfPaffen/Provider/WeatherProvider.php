<?php

namespace CAC\FfPaffen\Provider;

use CAC\ApiClient\CAC\WeatherClient;

use Silex\Application;

use Silex\ServiceProviderInterface;

class WeatherProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['weather.client'] = $app->share(function() use ($app) {
            return new WeatherClient($app['guzzle.client']);
        });
    }

    public function boot(Application $app)
    {
    }
}

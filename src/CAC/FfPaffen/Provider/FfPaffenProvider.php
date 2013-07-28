<?php

namespace CAC\FfPaffen\Provider;

use CAC\FfPaffen\FfPaffenService;

use Silex\Application;
use Silex\ServiceProviderInterface;

class FfPaffenProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['ffpaffen'] = $app->share(function() use ($app) {
            return new FfPaffenService($app['weather.client']);
        });
    }

    public function boot(Application $app)
    {
    }
}

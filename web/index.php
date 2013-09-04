<?php

use CAC\ApiClient\CAC\SunriseClient;

use CAC\ApiClient\CAC\WeatherClient;
use CAC\Component\Location\GeoIpAdapter\NetImpactAdapter;
use CAC\Component\Location\GeoIpAdapter\FreeGeoIpAdapter;
use CAC\Component\Location\GeoIpLocator;
use CAC\Component\Weather\RainForecast;

require __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app['apiUrl'] = 'http://api.ffpaffen.nl';
$app->register(new \Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../app/view'));
$app->register(new \Guzzle\GuzzleServiceProvider(), array('guzzle.base_url' => $app['apiUrl']));
$app->register(new \CAC\FfPaffen\Provider\WeatherProvider());
$app->register(new \CAC\FfPaffen\Provider\FfPaffenProvider());


$app->get('/', function() use ($app) {
    //$locator = new GeoIpLocator(new NetImpactAdapter('g5UTvftII9uZ9kjr'));
    $locator = new GeoIpLocator(new FreeGeoIpAdapter());

    $ip = $_SERVER['REMOTE_ADDR'];
    $location = $locator->find($ip);

    if (!$location->getLatitude() || !$location->getLongitude()) {
        $location->setLatitude(52);
        $location->setLongitude(4);
        $location->setCity("Nederland");
    }

    $rainAmount = $app['ffpaffen']->findByPosition($location->getLatitude(), $location->getLongitude());

    $ffpaffen = true;
    if ($rainAmount >= 50) {
        $ffpaffen = false;
    }

    return $app['twig']->render('index.twig', array('ffpaffen' => $ffpaffen, 'location' => $location));
});

$app->get('/paffen/{latitude}/{longitude}', function($latitude, $longitude) use ($app) {
    $rainAmount = $app['ffpaffen']->findByPosition($latitude, $longitude);

    $ffpaffen = true;
    if ($rainAmount >= 50) {
        $ffpaffen = false;
    }

    return $app->json(array('ffpaffen' => $ffpaffen));
});

$app->get('/sunrise/{latitude}/{longitude}', function($latitude, $longitude) use ($app) {
    $client = new SunriseClient($app['guzzle.client']);

    $sunrise = $client->getSunriseByPosition($latitude, $longitude);

    return $app->json($sunrise);
});


$app->run();

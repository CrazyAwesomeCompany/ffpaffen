<?php

use CAC\Component\Location\GeoIpLocator;

use CAC\Component\Weather\RainForecast;

require __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new \Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../app/view'));


$app->get('/', function() use ($app) {
    $locator = new GeoIpLocator();

    $location = $locator->get($_SERVER['REMOTE_ADDR']);
    if (!$location->latitude || !$location->longitude) {
        $location->latitude = 52;
        $location->longitude = 4;
        $location->city = "Nederland";
    }

    $forecast = new RainForecast();

    $data = $forecast->get($location->latitude, $location->longitude);

    $ffpaffen = true;

    $now = time();
    $current = null;
    foreach ($data as $row) {
        if ($row['time'] > $now) {
            $current = $row;
            break;
        }
    }

    $rainAmount = ltrim($current['amount'], '0');

    if ($rainAmount >= 100) {
        $ffpaffen = false;
    }

    return $app['twig']->render('index.twig', array('ffpaffen' => $ffpaffen, 'location' => $location));
});



$app->run();

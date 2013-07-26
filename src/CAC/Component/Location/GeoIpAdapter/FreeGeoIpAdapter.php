<?php

namespace CAC\Component\Location\GeoIpAdapter;


use CAC\Component\Location\Location;

class FreeGeoIpAdapter implements GeoIpAdapterInterface
{
    /**
     * FreeGeoIp Api Url
     *
     * @var string
     */
    private $api = 'http://freegeoip.net/json';


    /**
     * (non-PHPdoc)
     * @see \CAC\Component\Location\GeoIpAdapter\GeoIpAdapterInterface::findByIp()
     */
    public function findByIp($ip)
    {
        $data = file_get_contents($this->api . '/' . $ip);
        $data = json_decode($data);

        $location = new Location();
        $location->setIp($ip);
        $location->setCity($data->city);
        $location->setLatitude($data->latitude);
        $location->setLongitude($data->longitude);

        return $location;
    }
}

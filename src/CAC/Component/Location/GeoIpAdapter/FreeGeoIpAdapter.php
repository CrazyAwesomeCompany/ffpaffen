<?php

namespace CAC\Component\Location\GeoIpAdapter;


class FreeGeoIpAdapter implements GeoIpAdapterInterface
{
    private $api = 'http://freegeoip.net/json';


    public function findByIp($ip)
    {
        $data = file_get_contents($this->api . '/' . $ip);
        $data = json_decode($data);

        return $data;
    }
}

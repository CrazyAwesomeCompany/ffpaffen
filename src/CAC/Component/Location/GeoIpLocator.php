<?php

namespace CAC\Component\Location;


class GeoIpLocator
{
    private $api = 'http://freegeoip.net/json';


    public function get($hostname)
    {
        $data = file_get_contents($this->api . '/' . $hostname);
        $data = json_decode($data);

        return $data;
    }
}

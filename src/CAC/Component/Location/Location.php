<?php

namespace CAC\Component\Location;

class Location
{

    private $ip, $city, $latitude, $longitude;

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setLatitude($lat)
    {
        $this->latitude = $lat;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLongitude($lon)
    {
        $this->longitude = $lon;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
}

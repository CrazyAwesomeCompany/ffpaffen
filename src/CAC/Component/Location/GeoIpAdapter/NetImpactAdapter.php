<?php

namespace CAC\Component\Location\GeoIpAdapter;


use CAC\Component\Location\Location;

class NetImpactAdapter implements GeoIpAdapterInterface
{
    private $api = 'http://api.netimpact.com/qv1.php';

    private $key = 'g5UTvftII9uZ9kjr';

    public function findByIp($ip)
    {
        $payload = array(
            'key' => $this->key,
            'qt' => 'geoip',
            'd' => 'json',
            'hostname' => 1,
            'q' => $ip
        );

        $data = file_get_contents($this->api . '?' . http_build_query($payload));
        $data = json_decode($data);

        $location = new Location;
        $location->city = $data[0][0];
        $location->latitude = $data[0][4];
        $location->longitude = $data[0][5];

        return $location;
    }
}

<?php

namespace CAC\Component\Location\GeoIpAdapter;

use CAC\Component\Location\Location;

/**
 * The NetImpact GeoIp service Adapter
 *
 */
class NetImpactAdapter implements GeoIpAdapterInterface
{
    /**
     * NetImpact API Url
     *
     * @var string
     */
    private $api = 'http://api.netimpact.com/qv1.php';

    /**
     * NetImpact API Key
     *
     * @var string
     */
    private $key;


    public function __construct($apiKey)
    {
        $this->key = $apiKey;
    }

    /**
     * (non-PHPdoc)
     * @see \CAC\Component\Location\GeoIpAdapter\GeoIpAdapterInterface::findByIp()
     */
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
        $location->setIp($ip);
        $location->setCity($data[0][0]);
        $location->setLatitude($data[0][4]);
        $location->setLongitude($data[0][5]);

        return $location;
    }
}

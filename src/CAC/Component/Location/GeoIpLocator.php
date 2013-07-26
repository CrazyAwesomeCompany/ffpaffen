<?php

namespace CAC\Component\Location;


use CAC\Component\Location\GeoIpAdapter\GeoIpAdapterInterface;

class GeoIpLocator
{
    /**
     *
     * @var GeoIpAdapterInterface
     */
    private $adapter;

    public function __construct(GeoIpAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function find($ip)
    {
        return $this->adapter->findByIp($ip);
    }
}

<?php

namespace CAC\Component\Location\GeoIpAdapter;

use CAC\Component\Location\Location;

interface GeoIpAdapterInterface
{
    /**
     * Find the location based on the IP given
     *
     * @param string $ip The IP address
     *
     * @return Location
     */
    public function findByIp($ip);
}

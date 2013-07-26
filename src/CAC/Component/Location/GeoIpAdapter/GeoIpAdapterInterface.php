<?php

namespace CAC\Component\Location\GeoIpAdapter;

interface GeoIpAdapterInterface
{
    public function findByIp($ip);
}

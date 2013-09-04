<?php

namespace CAC\ApiClient\CAC;

use CAC\ApiClient\AbstractClient;

class SunriseClient extends AbstractClient
{
    public function getSunriseByPosition($latitude, $longitude, $day = null, $month = null, $year = null)
    {
        if (null === $day) {
            $day = date('d');
        }

        if (null === $month) {
            $month = date('m');
        }

        if (null === $year) {
            $year = date('Y');
        }

        $url = sprintf('sunrise/%s/%s/%s/%s/%s', urlencode($latitude), urlencode($longitude), $day, $month, $year);

        return parent::get($url);
    }
}

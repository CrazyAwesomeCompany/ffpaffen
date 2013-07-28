<?php

namespace CAC\ApiClient\CAC;

use CAC\ApiClient\AbstractClient;

class WeatherClient extends AbstractClient
{
    public function getRainByPosition($latitude, $longitude)
    {
        $url = sprintf('weather/position/%s/%s', urlencode($latitude), urlencode($longitude));

        return parent::get($url);
    }
}

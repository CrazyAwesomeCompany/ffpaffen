<?php

namespace CAC\FfPaffen;

use CAC\ApiClient\CAC\WeatherClient;

class FfPaffenService
{
    /**
     * @var CAC\ApiClient\CAC\WeatherClient
     */
    private $weatherClient;

    public function __construct(WeatherClient $weatherClient)
    {
        $this->weatherClient = $weatherClient;
    }

    public function findByPosition($latitude, $longitude)
    {
        $data = $this->weatherClient->getRainByPosition($latitude, $longitude);
       // print_r($data);
        $amount = $this->findCurrentTime($data);

        return $amount;
    }

    private function findCurrentTime(array $data)
    {
        $now = time();
        $current = null;
        foreach ($data as $row) {
            if ($row['time'] > $now) {
                $current = $row;
                break;
            }
        }

        $rainAmount = ltrim($current['amount'], '0');

        return $rainAmount;
    }
}

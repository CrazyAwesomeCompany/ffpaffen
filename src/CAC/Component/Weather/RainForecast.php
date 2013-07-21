<?php

namespace CAC\Component\Weather;

class RainForecast
{

    private $api = 'http://gps.buienradar.nl/getrr.php';

    public function get($lat, $lon)
    {
        $data = $this->getRainData($lat, $lon);
        $data = $this->parseData($data);

        return $data;
    }

    private function parseData($data)
    {
        $data = explode("\n", $data);
        $data = array_filter($data);

        $data = array_map(function($values) {
            list($amount, $time) = explode("|", $values, 2);
            list($hours, $minutes) = explode(":", $time, 2);
            $hours = trim(ltrim($hours, '0'));
            $minutes = trim(ltrim($minutes, '0'));
            if (!$minutes) {
                $minutes = 0;
            }

            $time = mktime($hours, $minutes);

            return array(
                'amount' => $amount,
                'time' => $time
            );
        }, $data);

        return $data;
    }

    private function getRainData($lat, $lon)
    {
        $params = array(
            'lat' => $lat,
            'lon' => $lon
        );

        $data = @file_get_contents($this->api . '?' . http_build_query($params));

        return $data;
    }






}

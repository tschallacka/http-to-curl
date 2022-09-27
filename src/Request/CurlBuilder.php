<?php

namespace Tschallacka\HttpToCurl\Request;

class CurlBuilder
{
    private RequestData $data;

    public function __construct(RequestData $data)
    {
        $this->data = $data;
    }

    /**
     * Returns an instantiated curl resource witch can be executed with curl_exec($curl_builder->get());
     * Or modified with your own curl arguments.
     * @return false|resource
     */
    public function get()
    {
        $ch = curl_init($this->data->getUrl());
        $method = $this->data->getMethod();
        if ($method !== 'GET') {
            $option = null;
            switch ($method) {
                case 'POST':
                    $option = CURLOPT_POST;
                    break;
                case 'PUT':
                    $option = CURLOPT_PUT;
                    break;
                case 'PATCH':
                    $option = CURLOPT_PATH_AS_IS;
                    break;
            }
            if ($option) {
                curl_setopt($ch, $option, true);
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }
        }
        if($this->data->getBody()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data->getBody());
        }

        $headers = $this->data->getHeaders();
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        $curl_headers = array_map(function ($value, $key) {
                    return ["$key: $value"];
                },
                $headers,
                array_keys($headers)
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);

        return $ch;
    }
}
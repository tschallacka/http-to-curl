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
        curl_setopt($ch, CURLOPT_HEADER,true);
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($this->data->getBody()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data->getBody());
        }
        else {
            curl_setopt($ch, CURLOPT_NOBODY,true);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = $this->data->getHeaders();

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
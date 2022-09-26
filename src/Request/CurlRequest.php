<?php

namespace Tschallacka\HttpToCurl\Request;

use Tschallacka\HttpToCurl\Exception\FileNotFoundException;
use Tschallacka\HttpToCurl\File\HttpReader;

class CurlRequest
{
    /**
     * @param string $filepath The path to the phpstorm HTTP file
     * @param callable|null $callable $callable A function that accepts one argument, the curl resource, to modify curl options.
     * @return string|null
     * @throws FileNotFoundException
     * @example CurlRequest::doRequest('get_products.http', function($ch) { curl_setopt($ch, CURLOPT_TIMEOUT, 3); });
     */
    public static function doRequest(string $filepath, callable $callable = null): ?string
    {
        $response = null;
        $curl = self::getCurlBuilder()->get();
        if ($curl) {
            if($callable) {
                $callable($curl);
            }
            $response = curl_exec($curl);
            curl_close($curl);
        }
        return $response;
    }

    /**
     * @throws FileNotFoundException
     */
    public static function getRequestData(string $filepath): RequestData
    {
        $http_reader = new HttpReader($filepath);
        return $http_reader->read();
    }

    /**
     * @throws FileNotFoundException
     */
    public static function getCurlBuilder(string $filepath): CurlBuilder
    {
        return new CurlBuilder(self::getRequestData($filepath));
    }
}
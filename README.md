### HTTP TO CURL

This library is there to help you to transform PHPSTORM's .http files to a php cURL request.

# Installation
```bash
  composer require tschallacka/http-to-curl
```

# Usage

## Tschallacka\HttpToCurl\Request\CurlRequest  
CurlRequest is a helper class to give you what you need without concern of how

**doRequest**  
This performs the request and returns the result.  
First argument: The PHPSTORM .http file.  
Second argument(optional): A callback to add your own curl options to the curl resource  
returns: request content  

```php 
use Tschallacka\HttpToCurl\Request\CurlRequest;

$result = CurlRequest::doRequest('path/to/request_file.http', function($ch) {
    curl_setopt($ch, CURLOPT_TIMEOUT, 42);
});
```

**getRequestData**  
This reads the http file and returns the parsed request data  
First argument: The PHPSTORM .http file  
returns: Tschallacka\HttpToCurl\Request\RequestData object

```php
use Tschallacka\HttpToCurl\Request\CurlRequest;

$data = CurlRequest::getRequestData('path/to/request_file.http');
```


**getCurlBuilder**  
This creates a curl resource builder from the given input file.  
First argument: The PHPSTORM .http file   
returns: Tschallacka\HttpToCurl\Request\CurlBuilder object

```php
use Tschallacka\HttpToCurl\Request\CurlRequest;

$data = CurlRequest::getCurlBuilder('path/to/request_file.http');
```

## Tschallacka\HttpToCurl\Request\CurlBuilder

**get**
This creates a new cURL resource when it's called, based on the contents of the .http file it was generated from.

```php
$response = null;
$builder = CurlRequest::getCurlBuilder($filepath);
$curl = $builder->get();
if ($curl) {
    $response = curl_exec($curl);
    curl_close($curl);
}
echo $response;
```


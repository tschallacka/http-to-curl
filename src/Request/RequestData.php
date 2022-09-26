<?php

namespace Tschallacka\HttpToCurl\Request;

class RequestData
{
    protected string $method;
    protected string $url;
    protected array $headers;
    protected string $body;

    public function __construct(
        string $method = 'GET',
        string $url = '',
        string $body = '',
        array  $headers = []
    )
    {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @param string $method
     * @return RequestData
     */
    public function setMethod(string $method): RequestData
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }


    /**
     * @param string $url
     * @return RequestData
     */
    public function setUrl(string $url): RequestData
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param array $headers
     * @return RequestData
     */
    public function setHeaders(array $headers): RequestData
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $body
     * @return RequestData
     */
    public function setBody(string $body): RequestData
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
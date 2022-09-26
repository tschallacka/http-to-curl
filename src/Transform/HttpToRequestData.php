<?php

namespace Tschallacka\HttpToCurl\Transform;

use Tschallacka\HttpToCurl\Request\RequestData;

class HttpToRequestData
{
    protected string $source;
    protected int $source_length;
    protected ?RequestData $output = null;
    protected int $current = 0;
    const END = PHP_EOL . PHP_EOL;
    const METHODS = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE'
    ];

    /**
     * Parser constructor.
     * @param $source
     */
    public function __construct($source)
    {
        $this->source = $source . self::END;
        $this->source_length = strlen($this->source);
    }

    protected function isAtEnd()
    {
        return $this->current >= $this->source_length;
    }

    protected function peek()
    {
        if ($this->isAtEnd()) return '';
        $this->current++;
        return $this->source[$this->current - 1];
    }

    protected function peekPrev()
    {
        if ($this->isAtEnd()) return '';
        return $this->source[$this->current - 1];
    }


    protected function peekUntil($end)
    {
        $value = '';
        $c = $this->peekPrev();
        while ($c != $end && !$this->isAtEnd()) {
            $value .= $c;
            $c = $this->peek();
        }

        return $value;
    }

    protected function parseKeyValueHeaders()
    {
        if ($this->isAtEnd()) return [];
        $c = $this->peekPrev() . $this->peek();
        $headers = [];
        while ($c != self::END && !$this->isAtEnd()) {
            $key = trim($this->peekUntil(":"));
            $this->peek();
            $value = trim($this->peekUntil(PHP_EOL));
            $c = $this->peekPrev() . $this->peek();

            $headers[$key] = $value;
        }

        return $headers;
    }

    protected function parseRequestBody()
    {
        if ($this->isAtEnd()) return '';

        $value = [];
        while (!$this->isAtEnd()) {
            $value[] = $this->peek();
        }
        return implode('', $value);
    }

    protected function parseRequest()
    {
        $data = new RequestData();
        $method = trim($this->peekUntil(" "));

        if (in_array($method, self::METHODS)) {
            $url = trim($this->peekUntil(PHP_EOL));

            // 2. Parse header key, value
            $headers = $this->parseKeyValueHeaders();
            $body = trim($this->parseRequestBody());
            $data->setMethod($method)
                ->setUrl($url)
                ->setHeaders($headers)
                ->setBody($body);
        }
        $this->output = $data;
    }

    public function parse()
    {
        while (!$this->isAtEnd()) {
            $c = $this->peek();
            switch ($c) {
                case 'P': // POST PUT PATCH
                case 'G': // GET
                case 'D': // Delete
                    $this->parseRequest();
                    break;
            }
        }

    }

    /**
     * @return RequestData|null
     */
    public function getResult()
    {
        return $this->output;
    }

}

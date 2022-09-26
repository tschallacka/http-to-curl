<?php

namespace Tschallacka\HttpToCurl\File;

use Tschallacka\HttpToCurl\Exception\FileNotFoundException;
use Tschallacka\HttpToCurl\Request\RequestData;
use Tschallacka\HttpToCurl\Transform\HttpToRequestData;

class HttpReader
{
    protected string $filepath;

    /**
     * @throws FileNotFoundException
     */
    public function __construct(
        string $filepath
    )
    {
        $this->filepath = $filepath;
        $this->checkIfExists();
    }

    /**
     * @throws FileNotFoundException
     */
    private function checkIfExists()
    {
        if (!file_exists($this->filepath)) {
            throw new FileNotFoundException($this->filepath);
        }
    }

    /**
     * Reads the input file and returns a RequestData
     * instance with the parsed data from the file.
     * @return RequestData
     */
    public function read(): RequestData
    {
        $contents = file_get_contents($this->filepath);
        $data_reader = new HttpToRequestData($contents);
        $data_reader->parse();
        return $data_reader->getResult();

    }

}
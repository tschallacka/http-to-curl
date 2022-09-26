<?php

namespace Tschallacka\HttpToCurl\Exception;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct($filepath, $code = 0, Throwable $previous = null)
    {
        parent::__construct("File not found: $filepath", $code, $previous);
    }
}
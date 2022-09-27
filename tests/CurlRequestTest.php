<?php

namespace Tschallacka\HttpToCurl\Tests;

use PHPUnit\Framework\TestCase;
use Tschallacka\HttpToCurl\Request\CurlRequest;

class CurlRequestTest extends TestCase
{

    public function testDoRequest()
    {
        $result = CurlRequest::doRequest(__DIR__.'/test14.http');
        $this->assertNotEmpty($result);
        $this->assertStringContainsString("BOOM BOOM", $result);
    }
}

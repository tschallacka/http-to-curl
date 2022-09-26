<?php

namespace Tschallacka\HttpToCurl\Tests;

use PHPUnit\Framework\TestCase;
use Tschallacka\HttpToCurl\Exception\FileNotFoundException;
use Tschallacka\HttpToCurl\Transform\HttpToRequestData;

class HttpToRequestDataTest extends TestCase
{

    public function testGetResult()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test1.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('GET', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertEmpty($data->getHeaders());
        $this->assertEmpty($data->getBody());
    }

    public function testGetResultWithHeader()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test2.http'));
        $request->parse();
        $data = $request->getResult();

        $this->assertEquals('GET', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertEmpty($data->getBody());
    }

    public function testPostResult()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test3.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('POST', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertEmpty($data->getHeaders());
        $this->assertEmpty($data->getBody());
    }

    public function testPostResultWithHeader()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test4.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('POST', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertEmpty($data->getBody());
    }

    public function testPostResultWithHeaderAndBody()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test5.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('POST', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertNotEmpty($data->getBody());
        $this->assertStringContainsString('FooBarBaz', $data->getBody());
        $this->assertStringContainsString('BezBalBuz', $data->getBody());
        $this->assertStringContainsString("\n", $data->getBody());
    }

    public function testPutResult()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test6.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('PUT', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertEmpty($data->getHeaders());
        $this->assertEmpty($data->getBody());
    }

    public function testPutResultWithHeader()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test7.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('PUT', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertEmpty($data->getBody());
    }

    public function testPutResultWithHeaderAndBody()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test8.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('PUT', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertNotEmpty($data->getBody());
        $this->assertStringContainsString('FooBarBaz', $data->getBody());
        $this->assertStringContainsString('BezBalBuz', $data->getBody());
        $this->assertStringContainsString("\n", $data->getBody());
    }

    public function testPatchResult()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test9.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('PATCH', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertEmpty($data->getHeaders());
        $this->assertEmpty($data->getBody());
    }

    public function testPatchResultWithHeader()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test10.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('PATCH', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertEmpty($data->getBody());
    }

    public function testPatchResultWithHeaderAndBody()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test11.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('PATCH', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertNotEmpty($data->getBody());
        $this->assertStringContainsString('FooBarBaz', $data->getBody());
        $this->assertStringContainsString('BezBalBuz', $data->getBody());
        $this->assertStringContainsString("\n", $data->getBody());
    }

    public function testDeleteResult()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test12.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('DELETE', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertEmpty($data->getHeaders());
        $this->assertEmpty($data->getBody());
    }

    public function testDeleteResultWithHeader()
    {
        $request = new HttpToRequestData(file_get_contents(__DIR__.'/test13.http'));
        $request->parse();
        $data = $request->getResult();
        $this->assertEquals('DELETE', $data->getMethod());
        $this->assertEquals('https://tschallacka.de', $data->getUrl());
        $this->assertNotEmpty($data->getHeaders());
        $this->assertArrayHasKey('Foo', $data->getHeaders());
        $this->assertEquals('bar', $data->getHeaders()['Foo']);
        $this->assertEmpty($data->getBody());
    }
}

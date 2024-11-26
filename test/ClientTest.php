<?php

namespace MultiDialogo\HtmlToPdfPrinterPhpClient\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use MultiDialogo\HtmlToPdfPrinterPhpClient\Client;
use PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{
    private $guzzleClientMock;

    private $client;

    public function testGetHtmlAsPdfStreamSuccess()
    {
        $htmlBody = '<h1>Hello, World!</h1>';
        $callerService = 'TestService';
        $filePath = __DIR__ . '/resources/empty.pdf';

        $this->guzzleClientMock->method('post')->willReturn(new Response(200, [], json_encode([
            'data' => [
                'attributes' => [
                    'sharedFilePath' => $filePath
                ]
            ]
        ])));

        // Create the file for testing
        touch($filePath);
        $stream = $this->client->getHtmlAsPdfStream($callerService, $htmlBody);

        $this->assertTrue(is_resource($stream)); // Use is_resource() instead of assertIsResource()
        fclose($stream);
    }

    public function testGetHtmlAsPdfStreamMissingFile()
    {
        $htmlBody = '<h1>Hello, World!</h1>';
        $callerService = 'TestService';
        $filePath = __DIR__ . '/path/to/missing/file.pdf';

        // Mock the response from the Guzzle client
        $this->guzzleClientMock->method('post')->willReturn(new Response(200, [], json_encode([
            'data' => [
                'attributes' => [
                    'sharedFilePath' => $filePath
                ]
            ]
        ])));

        $this->setExpectedException('RuntimeException', "Missing file @ {$filePath}"); // Change to setExpectedException

        $this->client->getHtmlAsPdfStream($callerService, $htmlBody);
    }

    public function testGetHtmlAsPdfStreamRequestException()
    {
        $htmlBody = '<h1>Hello, World!</h1>';
        $callerService = 'TestService';

        $this->guzzleClientMock->method('post')
            ->will($this->throwException(new RequestException("Error during request", new \GuzzleHttp\Psr7\Request('POST', 'test')))); // Use throwException

        $this->setExpectedException('RuntimeException', "Error during request"); // Change to setExpectedException

        $this->client->getHtmlAsPdfStream($callerService, $htmlBody);
    }

    protected function setUp()
    {
        $this->guzzleClientMock = $this->getMockBuilder(GuzzleClient::class) // Updated mock creation for PHPUnit 4.8
            ->disableOriginalConstructor()
            ->setMethods(['post'])
            ->getMock();

        $this->client = new Client('https://api.example.com');
        $this->client->setClient($this->guzzleClientMock);
    }
}

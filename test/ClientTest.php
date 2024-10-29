<?php

namespace MultiDialogo\HtmlToPdfPrinterPhpClient\Test;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use MultiDialogo\HtmlToPdfPrinterPhpClient\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private GuzzleClient $guzzleClientMock;

    private Client $client;

    protected function setUp(): void
    {
        $this->guzzleClientMock = $this->createMock(GuzzleClient::class);

        $this->client = new Client('https://api.example.com');
        $this->client->setClient($this->guzzleClientMock);
    }

    public function testGetHtmlAsPdfStreamSuccess()
    {
        $htmlBody = '<h1>Hello, World!</h1>';
        $callerService = 'TestService';
        $filePath = '/path/to/valid/file.pdf';

        $this->guzzleClientMock->method('post')->willReturn(new Response(200, [], json_encode([
            'data' => [
                'attributes' => [
                    'sharedFilePath' => $filePath
                ]
            ]
        ])));

        touch($filePath);
        $stream = $this->client->getHtmlAsPdfStream($callerService, $htmlBody);

        $this->assertIsResource($stream);
        fclose($stream);

        unlink($filePath);
    }

    public function testGetHtmlAsPdfStreamMissingFile()
    {
        $htmlBody = '<h1>Hello, World!</h1>';
        $callerService = 'TestService';
        $filePath = '/path/to/missing/file.pdf';

        // Mock the response from the Guzzle client
        $this->guzzleClientMock->method('post')->willReturn(new Response(200, [], json_encode([
            'data' => [
                'attributes' => [
                    'sharedFilePath' => $filePath
                ]
            ]
        ])));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Missing file @ {$filePath}");

        $this->client->getHtmlAsPdfStream($callerService, $htmlBody);
    }

    public function testGetHtmlAsPdfStreamRequestException()
    {
        $htmlBody = '<h1>Hello, World!</h1>';
        $callerService = 'TestService';

        $this->guzzleClientMock->method('post')
            ->willThrowException(new RequestException("Error during request", new Request('POST', 'test')));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error during request");

        $this->client->getHtmlAsPdfStream($callerService, $htmlBody);
    }
}

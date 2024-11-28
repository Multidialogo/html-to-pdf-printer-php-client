<?php

namespace MultiDialogo\HtmlToPdfPrinterPhpClient;

use GuzzleHttp\Client as GuzzleHttpClient;
use RuntimeException;
use stdClass;

class Client
{
    private const HTML_TO_PDF_ENDPOINT = '/download';

    private GuzzleHttpClient $client;

    public function __construct(string $baseUri)
    {
        $this->client = new GuzzleHttpClient(['base_uri' => $baseUri]);
    }

    public function setClient(GuzzleHttpClient $guzzleClient)
    {
        $this->client = $guzzleClient;
    }

    public function getHtmlAsPdfStream(
        string $callerService,
        string $htmlBody
    ): string
    {
        $requestPayload = new stdClass();
        $requestPayload->data = new stdClass();
        $requestPayload->data->attributes = new stdClass();
        $requestPayload->data->attributes->htmlBody = $htmlBody;

        $response = $this->client->post(
            static::HTML_TO_PDF_ENDPOINT,
            [
                'json' => $requestPayload,
                'headers' => [
                    'X-caller-service' => $callerService,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]
        );

        $responseData = json_decode($response->getBody()->getContents());

        return $responseData->data->attributes->sharedFilePath;
    }
}

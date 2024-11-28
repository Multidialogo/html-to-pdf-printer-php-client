<?php

namespace MultiDialogo\HtmlToPdfPrinterPhpClient;

use GuzzleHttp\Client as GuzzleHttpClient;
use RuntimeException;
use stdClass;

class Client
{
    const HTML_TO_PDF_ENDPOINT = '/download';

    private $client;

    public function __construct($baseUri)
    {
        $this->client = new GuzzleHttpClient(['base_uri' => $baseUri]);
    }

    public function setClient(GuzzleHttpClient $guzzleClient)
    {
        $this->client = $guzzleClient;
    }

    public function getHtmlAsPdfStream(
        $callerService,
        $htmlBody
    )
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

<?php

require_once(dirname(__FILE__) . '/../src/ResponseFormatter.class.php');
require_once('vendor/bprollinson/bolognese-response-formatter-api/src/ResponseFormatted.class.php');
require_once('vendor/bprollinson/bolognese-response-formatter-api/src/HTTPResponse.class.php');
require_once('vendor/bprollinson/bolognese-controller-api/src/MethodInvoked.class.php');

use PHPUnit\Framework\TestCase;

class ResponseFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function formatUsesDefaultResponseWhenNoMappingDefined()
    {
        $responseMapping = [
            'mapping' => [],
            'default' => [
                'httpStatusCode' => 200,
                'headers' => []
            ]
        ];
        $responseFormatter = new ResponseFormatter($responseMapping);

        $expectedResponseFormatted = new ResponseFormatted(new HTTPResponse(200, [], '"response"'));
        $responseFormatted = $responseFormatter->format(new MethodInvoked('entity_created', 'response'));
        $this->assertEquals($expectedResponseFormatted, $responseFormatted);
    }

    /**
     * @test
     */
    public function formatUsesDefaultResponseWithHeadersWhenNoMappingDefined()
    {
        $responseMapping = [
            'mapping' => [],
            'default' => [
                'httpStatusCode' => 200,
                'headers' => [
                    'headerkey1' => 'headervalue1',
                    'headerkey2' => 'headervalue2'
                ]
            ]
        ];
        $responseFormatter = new ResponseFormatter($responseMapping);

        $expectedResponseFormatted = new ResponseFormatted(new HTTPResponse(
            200,
            [
                'headerkey1' => 'headervalue1',
                'headerkey2' => 'headervalue2'
            ],
            '"response"'
        ));
        $responseFormatted = $responseFormatter->format(new MethodInvoked('entity_created', 'response'));
        $this->assertEquals($expectedResponseFormatted, $responseFormatted);
    }

     /**
      * @test
      */
     public function formatUsesMappedResponse()
     {
         $responseMapping = [
            'mapping' => [
                [
                    'key' => 'entity_not_found',
                    'httpStatusCode' => 404,
                    'headers' => []
                ]
            ]
        ];
        $responseFormatter = new ResponseFormatter($responseMapping);

        $expectedResponseFormatted = new ResponseFormatted(new HTTPResponse(404, [], '"response"'));
        $responseFormatted = $responseFormatter->format(new MethodInvoked('entity_not_found', 'response'));
        $this->assertEquals($expectedResponseFormatted, $responseFormatted);
     }
 
      /**
      * @test
      */
     public function formatUsesMappedResponseWithHeader()
     {
         $responseMapping = [
            'mapping' => [
                [
                    'key' => 'entity_not_found',
                    'httpStatusCode' => 404,
                    'headers' => [
                        'headerkey1' => 'headervalue1',
                        'headerkey2' => 'headervalue2'
                    ]
                ]
            ]
        ];
        $responseFormatter = new ResponseFormatter($responseMapping);

        $expectedResponseFormatted = new ResponseFormatted(new HTTPResponse(
            404,
            [
                'headerkey1' => 'headervalue1',
                'headerkey2' => 'headervalue2'
            ],
            '"response"'
        ));
        $responseFormatted = $responseFormatter->format(new MethodInvoked('entity_not_found', 'response'));
        $this->assertEquals($expectedResponseFormatted, $responseFormatted);
     }
}

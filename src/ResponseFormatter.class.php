<?php

require_once('vendor/bprollinson/bolognese-controller-api/src/MethodInvoked.class.php');
require_once('vendor/bprollinson/bolognese-response-formatter-api/src/ResponseFormatted.class.php');
require_once('vendor/bprollinson/bolognese-response-formatter-api/src/HTTPResponse.class.php');

class ResponseFormatter
{
    private $responseMapping;

    public function __construct($responseMapping)
    {
        $this->responseMapping = $responseMapping;
    }

    public function format(MethodInvoked $methodInvoked)
    {
        foreach ($this->responseMapping['mapping'] as $possibleResponseType)
        {
            if ($methodInvoked->getResponse() == $possibleResponseType['key'])
            {
                $responseBody = json_encode($methodInvoked->getResponseValue());
                $httpResponse = new HTTPResponse($possibleResponseType['httpStatusCode'], $possibleResponseType['headers'], $responseBody);

                return new ResponseFormatted($httpResponse);
            }
        }

        $responseBody = json_encode($methodInvoked->getResponseValue());
        $defaultResponseType = $this->responseMapping['default'];
        $httpResponse = new HTTPResponse($defaultResponseType['httpStatusCode'], $defaultResponseType['headers'], $responseBody);

        return new ResponseFormatted($httpResponse);
    }
}

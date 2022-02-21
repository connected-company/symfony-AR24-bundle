<?php

namespace Connected\AR24Bundle\Service;

use Connected\AR24Bundle\Exception\AR24BundleException;
use Connected\AR24Bundle\Model\ApiUser;
use Connected\AR24Bundle\Model\EndPoints;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;


class AbstractAR24Client
{
    /**
     * @throws \JsonException
     * @throws AR24BundleException
     */
    protected function processAR24Response(Response $response) {
        $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (isset($response['status']) && strtolower($response['status']) === 'maintenance') {
            throw new AR24BundleException('AR24 is currently undergoing maintenance.', null, 422);
        }

        if (isset($response['status']) && strtolower($response['status']) === 'error') {
            throw new AR24BundleException($response['message'], 422);
        }

        return $response;
    }
}

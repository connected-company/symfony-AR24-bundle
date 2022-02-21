<?php

namespace Connected\AR24Bundle\Service;

use Connected\AR24Bundle\Model\ApiUser;
use Connected\AR24Bundle\Model\EndPoints;
use GuzzleHttp\Client;


class AR24Client extends AbstractAR24Client implements AR24ClientInterface
{
    const TIMEOUT = 20.0;

    protected Client $client;

    protected string $apiUrl;

    protected ApiUser $apiUser;

    public function __construct(string $apiUrl, ApiUser $apiUser)
    {
        $this->apiUrl = $apiUrl;
        $this->apiUser = $apiUser;
        $this->client = new Client(
            [
                'base_uri' => $this->apiUrl
            ]
        );
    }


    /**
     * @param ApiUser $apiUser
     * @return array
     * @throws \Connected\AR24Bundle\Exception\AR24BundleException
     * @throws \JsonException
     */
    public function connect(ApiUser $apiUser): array
    {
        $response = $this->processAR24Response($this->client->get(
            EndPoints::GET_USER . '?' . http_build_query(
                ['email' => $apiUser->getEmail(), 'token' => $apiUser->getToken()]
            )
        ));
    }
}

<?php

namespace Connected\AR24Bundle\Service;


use Connected\AR24Bundle\Exception\AR24BundleException;
use Connected\AR24Bundle\Model\ApiUser;
use Connected\AR24Bundle\Model\Attachment;
use Connected\AR24Bundle\Model\EndPoints;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;


class AbstractAR24Client
{
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
     * @return void
     * @throws AR24BundleException
     */
    public function connect(): void
    {
        try {
            $response = $this->processAR24Response(
                $this->client->get(
                    EndPoints::GET_USER . '?' . http_build_query(
                        ['email' => $this->apiUser->getEmail(), 'token' => $this->apiUser->getToken()]
                    )
                ));

            $this->apiUser->setAr24Id($response['result']['id']);

        } catch (\Exception $e) {
            throw new AR24BundleException('Unable to connect with specified credentials.');
        }
    }

    /**
     * @param string $endPoint
     * @param array $parameters
     * @return array
     * @throws AR24BundleException
     * @throws \JsonException
     */
    public function get(string $endPoint, array $parameters = []): array
    {
        $this->checkCredential();

        $response = $this->client->get(
            $endPoint . '?' . http_build_query(
                array_merge(
                    $parameters,
                    ['token' => $this->apiUser->getToken(), 'id_user' => $this->apiUser->getAr24Id()]
                )
            )
        );

        return $this->processAR24Response($response);
    }


    /**
     * @param string $endPoint
     * @param array $parameters
     * @param array $attachments
     * @return array
     * @throws AR24BundleException
     * @throws \JsonException
     */
    public function post(
        string  $endPoint,
        array   $parameters = [],
        ?Attachment $attachment = null
    ): array
    {
        $this->checkCredential();

        $data['multipart'] = [
            ['name' => 'token', 'contents' => $this->apiUser->getToken()],
            ['name' => 'id_user', 'contents' => $this->apiUser->getAr24Id()],
        ];

        foreach ($parameters as $key => $value) {
            $data['multipart'][] = ['name' => $key, 'contents' => $value];
        }


        if ($attachment) {
            if (!($attachment instanceof Attachment)) {
                throw new AR24BundleException('Attachements not instance of ' . Attachment::class);
            }
            $data['multipart'][] = ['name' => 'file', 'contents' => fopen($attachment->getFilepath(), 'rb')];
        }

        return $this->processAR24Response($this->client->post($endPoint, $data));
    }

    /**
     * @throws \JsonException
     * @throws AR24BundleException
     */
    private function processAR24Response(Response $response)
    {
        $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (isset($response['status']) && strtolower($response['status']) === 'maintenance') {
            throw new AR24BundleException('AR24 est actuellement en maintenance.',422);
        }

        if (isset($response['status']) && strtolower($response['status']) === 'error') {
            throw new AR24BundleException($response['message'], 422);
        }

        return $response;
    }

    /**
     * @return void
     * @throws AR24BundleException
     */
    protected function checkCredential(): void
    {
        if (!$this->apiUser->getAr24Id()) {
            $this->connect();
        }
    }

}

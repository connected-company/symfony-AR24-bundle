<?php

namespace Connected\AR24Bundle\Service;


use Connected\AR24Bundle\Exception\AR24BundleException;
use Connected\AR24Bundle\Exception\AR24InvalidEmailException;
use Connected\AR24Bundle\Model\ApiUser;
use Connected\AR24Bundle\Model\Attachment;
use Connected\AR24Bundle\Model\EndPoints;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;


class AbstractAR24Client
{
    public function __construct(
        protected string $apiUrl,
        protected ApiUser $apiUser,
        private HttpClientInterface $client)
    {
        $this->client = $this->client->withOptions([
                'base_uri' => $this->apiUrl,
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
                $this->client->request(
                    Request::METHOD_GET,
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

        $response = $this->client->request(
            Request::METHOD_GET,
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
        string      $endPoint,
        array       $parameters = [],
        ?Attachment $attachment = null
    ): array
    {
        $this->checkCredential();

        $parts = [
            'token' => $this->apiUser->getToken(),
            'id_user' => $this->apiUser->getAr24Id()
        ];
        foreach ($parameters as $key => $value) {
            $parts[$key] = $value ?? '';
        }

        if ($attachment) {
            $explodedPath = explode(DIRECTORY_SEPARATOR, $attachment->getFilepath());
            $filename = $explodedPath[count($explodedPath)-1];
            $fileContent = @file_exists($attachment->getFilepath()) ? file_get_contents($attachment->getFilepath()) : $attachment->getFilepath();
            if (!($attachment instanceof Attachment)) {
                throw new AR24BundleException('Attachments not instance of ' . Attachment::class);
            }
            $parts['file'] = new DataPart($fileContent, $filename);
        }
        $formData = new FormDataPart($parts);

        $data = [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ];

        return $this->processAR24Response(
            $this->client->request(
                Request::METHOD_POST,
                $endPoint,
                $data
            )
        );
    }

    /**
     * @throws \JsonException
     * @throws AR24BundleException
     */
    private function processAR24Response(ResponseInterface $response)
    {
        $response = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (isset($response['status']) && strtolower($response['status']) === 'maintenance') {
            throw new AR24BundleException('AR24 est actuellement en maintenance.', 422);
        }

        if (isset($response['status']) && strtolower($response['status']) === 'error') {
            if (isset($response['slug']) &&
                (strtolower($response['slug']) === 'invalid_email' || strtolower($response['slug']) === 'invalid_recipient')) {
                throw new AR24InvalidEmailException($response['message']);
            }
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

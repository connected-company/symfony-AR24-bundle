<?php

namespace Connected\AR24Bundle\Service;

use Connected\AR24Bundle\Exception\AR24BundleException;
use Connected\AR24Bundle\Model\Attachment;
use Connected\AR24Bundle\Model\EndPoints;
use Connected\AR24Bundle\Model\LRE;
use Connected\AR24Bundle\Response\AttachmentResponse;
use Connected\AR24Bundle\Response\LREResponse;

class AR24Client extends AbstractAR24Client implements AR24ClientInterface
{

    public function uploadAttachment(Attachment $attachment): AttachmentResponse
    {
        $response = $this->post(
            EndPoints::POST_ATTACHMENT,
            [],
            $attachment
        );

        return new AttachmentResponse($response['result']);
    }

    /**
     * @param string $id
     * @return LREResponse
     * @throws AR24BundleException
     * @throws \JsonException
     */
    public function getLREInformations(string $id): LREResponse
    {
        $response = $this->get(
            EndPoints::GET_LRE_INFO,
            ['id' => $id]
        );

        return new LREResponse($response['status'], $response['result']);
    }

    /**
     * @param array $ids
     * @return array
     * @throws AR24BundleException
     * @throws \JsonException
     */
    public function getLREListByIds(array $ids = []): array
    {
        $response = $this->get(
            EndPoints::GET_REGISTERED_LRE_LIST,
            ['mail' => $ids]
        );

        return array_map(function ($lre) use ($response) {
            return new LREResponse($response['status'], $lre);
        }, $response['result']);
    }


    public function sendLRE(LRE $lre): LREResponse
    {
        $data = [
            'to_lastname' => $lre->getDestinataire()->getNom(),
            'to_firstname' => $lre->getDestinataire()->getPrenom(),
            'to_company' => $lre->getDestinataire()->getSociete(),
            'to_email' => $lre->getDestinataire()->getEmail(),
            'dest_statut' => $lre->getDestinataire()->getStatus(),
            'ref_client' => $lre->getDestinataire()->getReference(),
            'content' => $lre->getContent(),
            ''
        ];

        foreach ($lre->getAttachements() as $key => $attachment) {
            if ($attachment instanceof AttachmentResponse){
                $data['attachment[' . $key . ']'] = $attachment->getId();
            }
            if ($attachment instanceof Attachment) {
                $data['attachment[' . $key . ']'] = $this->uploadAttachment($attachment)->getId();
            }

        }

        $response = $this->post(
            EndPoints::POST_LRE,
            $data
        );

        return new LREResponse($response['status'], $response['result']);
    }
}

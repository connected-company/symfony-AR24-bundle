<?php

namespace Connected\AR24Bundle\Service;


use Connected\AR24Bundle\Model\Attachment;
use Connected\AR24Bundle\Model\LRE;
use Connected\AR24Bundle\Response\AttachmentResponse;
use Connected\AR24Bundle\Response\LREResponse;

interface AR24ClientInterface
{
    public function connect(): void;

    public function get(string $endPoint, array $parameters = []): array;

    public function post(
        string  $endPoint,
        array   $parameters = [],
        ?Attachment $attachment = null
    ): array;

    public function uploadAttachment(Attachment $attachment): AttachmentResponse;

    public function getLREInformations(string $id): LREResponse;

    public function getLREListByIds(array $ids = []): array;

    public function sendLRE(LRE $lre): LREResponse;
}
<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Response;

use Connected\AR24Bundle\Exception\AR24BundleException;

/**
 * Response for email.
 */
class LREResponse extends StatusResponse
{

    protected $id;

    protected ?string $emailStatus;

    protected ?DestinataireResponse $recipientResponse;

    protected ?string $referenceDossier;

    protected ?bool $sendFail;

    protected ?array $attachments;

    protected ?string $proofDepotUrl;

    protected ?\DateTime $dateSent;

    protected ?\DateTime $dateOpened;

    protected ?\DateTime $dateRefused;

    protected ?\DateTime $dateExpired;

    protected ?string $proofEnvoiUrl;

    protected ?string $proofArUrl;

    /**
     * Constructor.
     *
     * @param string $status Status.
     * @param array $data Data.
     * @throws AR24BundleException
     */
    public function __construct(string $status, array $data)
    {
        parent::__construct($status);

        $this->id = $data['id'] ?? null;
        $this->emailStatus = $data['status'] ?? null;
        $this->referenceDossier = $data['ref_dossier'] ?? null;
        $this->dateSent = !empty($data['ts_ev_date']) ? \DateTime::createFromFormat(
            'Y-m-d H:i:s', $data['ts_ev_date']) : null;
        $this->dateOpened = !empty($data['view_date']) ? \DateTime::createFromFormat(
            'Y-m-d H:i:s', $data['view_date']) : null;
        $this->dateRefused = !empty($data['refused_date']) ? \DateTime::createFromFormat(
            'Y-m-d H:i:s', $data['refused_date']) : null;
        $this->dateExpired = !empty($data['negligence_date']) ? \DateTime::createFromFormat(
            'Y-m-d H:i:s', $data['negligence_date']) : null;
        $this->sendFail = $data['send_fail'] ?? null;
        $this->recipientResponse = new DestinataireResponse($data);
        $this->proofDepotUrl = $data['proof_dp_url'] ?? null;
        $this->proofEnvoiUrl = $data['proof_ev_url'] ?? null;
        $this->proofArUrl = $data['proof_ar_url'] ?? null;

        if (isset($data['attachments_details'])) {
            foreach ($data['attachments_details'] as $attachment) {
                $this->attachments[] = new AttachmentResponse($attachment);
            }
        }
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string|null
     */
    public function getEmailStatus()
    {
        return $this->emailStatus;
    }

    /**
     * @param mixed|string|null $emailStatus
     */
    public function setEmailStatus($emailStatus): void
    {
        $this->emailStatus = $emailStatus;
    }

    /**
     * @return DestinataireResponse|null
     */
    public function getRecipientResponse(): ?DestinataireResponse
    {
        return $this->recipientResponse;
    }

    /**
     * @param DestinataireResponse|null $recipientResponse
     */
    public function setRecipientResponse(?DestinataireResponse $recipientResponse): void
    {
        $this->recipientResponse = $recipientResponse;
    }

    /**
     * @return mixed|string|null
     */
    public function getReferenceDossier()
    {
        return $this->referenceDossier;
    }

    /**
     * @param mixed|string|null $referenceDossier
     */
    public function setReferenceDossier($referenceDossier): void
    {
        $this->referenceDossier = $referenceDossier;
    }

    /**
     * @return mixed|string|null
     */
    public function getSendFail()
    {
        return $this->sendFail;
    }

    /**
     * @param bool|null $sendFail
     */
    public function setSendFail($sendFail): void
    {
        $this->sendFail = $sendFail;
    }

    /**
     * @return array|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * @param array|null $attachments
     */
    public function setAttachments(?array $attachments): void
    {
        $this->attachments = $attachments;
    }

    /**
     * @return mixed|string|null
     */
    public function getProofDepotUrl()
    {
        return $this->proofDepotUrl;
    }

    /**
     * @param mixed|string|null $proofDepotUrl
     */
    public function setProofDepotUrl($proofDepotUrl): void
    {
        $this->proofDepotUrl = $proofDepotUrl;
    }

    /**
     * @return \DateTime|false|null
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * @param \DateTime|false|null $dateSent
     */
    public function setDateSent($dateSent): void
    {
        $this->dateSent = $dateSent;
    }

    /**
     * @return \DateTime|false|null
     */
    public function getDateOpened()
    {
        return $this->dateOpened;
    }

    /**
     * @param \DateTime|false|null $dateOpened
     */
    public function setDateOpened($dateOpened): void
    {
        $this->dateOpened = $dateOpened;
    }

    /**
     * @return \DateTime|false|null
     */
    public function getDateRefused()
    {
        return $this->dateRefused;
    }

    /**
     * @param \DateTime|false|null $dateRefused
     */
    public function setDateRefused($dateRefused): void
    {
        $this->dateRefused = $dateRefused;
    }

    /**
     * @return \DateTime|false|null
     */
    public function getDateExpired()
    {
        return $this->dateExpired;
    }

    /**
     * @param \DateTime|false|null $dateExpired
     */
    public function setDateExpired($dateExpired): void
    {
        $this->dateExpired = $dateExpired;
    }

    /**
     * @return mixed|string|null
     */
    public function getProofEnvoiUrl()
    {
        return $this->proofEnvoiUrl;
    }

    /**
     * @param mixed|string|null $proofEnvoiUrl
     */
    public function setProofEnvoiUrl($proofEnvoiUrl): void
    {
        $this->proofEnvoiUrl = $proofEnvoiUrl;
    }

    /**
     * @return mixed|string|null
     */
    public function getProofArUrl()
    {
        return $this->proofArUrl;
    }

    /**
     * @param mixed|string|null $proofArUrl
     */
    public function setProofArUrl($proofArUrl): void
    {
        $this->proofArUrl = $proofArUrl;
    }
}

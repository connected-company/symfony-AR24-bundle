<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Model;

use Connected\AR24Bundle\Exception\AR24BundleException;

/**
 * Attachment model.
 */
class LRE
{
   private Destinataire $destinataire;

   private ?string $content;

   private array $attachements = [];

    /**
     * @param Destinataire $destinataire
     */
    public function __construct(Destinataire $destinataire)
    {
        $this->destinataire = $destinataire;
    }

    /**
     * @return Destinataire
     */
    public function getDestinataire(): Destinataire
    {
        return $this->destinataire;
    }

    /**
     * @param Destinataire $destinataire
     */
    public function setDestinataire(Destinataire $destinataire): void
    {
        $this->destinataire = $destinataire;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getAttachements(): array
    {
        return $this->attachements;
    }

    /**
     * @param array $attachements
     */
    public function setAttachements(array $attachements): void
    {
        $this->attachements = $attachements;
    }
}

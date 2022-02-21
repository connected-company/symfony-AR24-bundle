<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Model;

use Connected\AR24Bundle\Exception\AR24BundleException;

/**
 * Recipient model.
 */
class Destinataire
{
    public const STATUT_PRO = 'professionnel';
    public const STATUT_PARTICULIER = 'particulier';

    private string $nom;

    private string $prenom;

    private string $email;

    private ?string $societe;

    private ?string $reference;

    /**
     * Constructor.
     *
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param string|null $societe
     * @param string|null $reference référence utilisateur AR24
     * @throws AR24BundleException
     */
    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        ?string $societe = null,
        ?string $reference = null
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->societe = $societe;
        $this->reference = $reference;
        $this->setEmail($email);
    }

    /**
     * Set and validate the email.
     *
     * @param string $email API email.
     *
     * @return self
     * @throws AR24BundleException
     */
    public function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AR24BundleException('The email is invalid', 500);
        }

        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string|null
     */
    public function getSociete(): ?string
    {
        return $this->societe;
    }

    /**
     * @param string|null $societe
     */
    public function setSociete(?string $societe): void
    {
        $this->societe = $societe;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     */
    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return empty($this->societe) ? self::STATUT_PARTICULIER : self::STATUT_PRO;
    }
}

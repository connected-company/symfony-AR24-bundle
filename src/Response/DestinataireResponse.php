<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Response;

use Connected\AR24Bundle\Exception\AR24BundleException;
use Connected\AR24Bundle\Model\Destinataire;

/**
 * Recipient model.
 */
class DestinataireResponse extends Destinataire
{
    /**
     * Constructor.
     *
     * @param array $data Response data.
     * @throws AR24BundleException
     */
    public function __construct(array $data)
    {
        parent::__construct(
            $data['to_lastname'],
            $data['to_firstname'],
            $data['to_email'],
            $data['to_company'] ?? null,
            $data['ref_client'] ?? null
        );
    }
}

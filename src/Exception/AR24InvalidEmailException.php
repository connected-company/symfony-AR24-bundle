<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Exception;

/**
 * Exception for Ar24 API.
 */
class AR24InvalidEmailException extends AR24BundleException
{
    /**
     * Constructor.
     *
     * @param string $message Message.
     * @param integer $code Error code.
     */
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
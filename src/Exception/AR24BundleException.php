<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Exception;

/**
 * Exception for Ar24 API.
 */
class AR24BundleException extends \Exception
{
    /**
     * Constructor.
     *
     * @param string $message Message.
     * @param integer $code Error code.
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
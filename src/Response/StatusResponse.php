<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Response;

/**
 * Response for status.
 */
class StatusResponse
{
    /**
     * @var string
     */
    protected string $status;

    /**
     * Constructor.
     *
     * @param string $status Status.
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}

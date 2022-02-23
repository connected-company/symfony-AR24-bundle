<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Response;

/**
 * Attachment model.
 */
class AttachmentResponse
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * Constructor.
     *
     * @param array $data Response data.
     */
    public function __construct(array $data)
    {
        $this->id = $data['file_id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}

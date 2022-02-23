<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Model;

use Connected\AR24Bundle\Exception\AR24BundleException;

/**
 * Attachment model.
 */
class Attachment
{
    private string $filepath;

    /**
     * Constructor.
     *
     * @param string $filepath File path.
     *
     * @throws AR24BundleException File does not exists.
     */
    public function __construct(string $filepath)
    {
        if (!file_exists($filepath)) {
            throw new AR24BundleException('File `' . $filepath . '` does not exists', 500);
        }

        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath(string $filepath): void
    {
        $this->filepath = $filepath;
    }
}

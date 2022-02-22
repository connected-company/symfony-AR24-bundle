<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Model;

use Connected\AR24Bundle\Exception\AR24BundleException;

/**
 * User model.
 */
class ApiUser
{
    protected string $email;

    protected string $token;

    protected ?string $otpCode = null;

    protected ?string $ar24Id = null;

    /**
     * Constructor.
     *
     * @param string $email User's email.
     * @param string $token User's token.
     * @param string|null $otpCode OTP Code.
     * @throws AR24BundleException
     */
    public function __construct(string $email, string $token, string $otpCode = null)
    {
        $this->setEmail($email);
        $this->setToken($token);
        $this->setOtpCode($otpCode);
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
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string|null
     */
    public function getOtpCode(): ?string
    {
        return $this->otpCode;
    }

    /**
     * Set and validate the email.
     *
     * @param string $email API email.
     *
     * @return self
     * @throws AR24BundleException
     *
     */
    private function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AR24BundleException('The email is invalid', 500);
        }

        $this->email = $email;

        return $this;
    }

    /**
     * Set and validate the token.
     *
     * @param string $token Token access.
     *
     *
     * @return self
     * @throws AR24BundleException
     */
    private function setToken(string $token): self
    {
        if (empty($token)) {
            throw new AR24BundleException('Token is invalid. The token can\'t be empty.', 500);
        }

        $this->token = $token;

        return $this;
    }

    /**
     * Set and validate the OTP code.
     *
     * @param string|null $otpCode OTP Code.
     *
     *
     * @return self
     * @throws AR24BundleException
     */
    private function setOtpCode(?string $otpCode): self
    {
        if (!is_null($otpCode) && empty($otpCode)) {
            throw new AR24BundleException('OTP code is invalid. The OTP code can\'t be empty.', 500);
        }

        $this->otpCode = $otpCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAr24Id(): ?string
    {
        return $this->ar24Id;
    }

    /**
     * @param string|null $ar24Id
     * @return ApiUser
     */
    public function setAr24Id(?string $ar24Id): ApiUser
    {
        $this->ar24Id = $ar24Id;
        return $this;
    }
}
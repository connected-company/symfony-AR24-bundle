<?php declare(strict_types=1);

namespace Connected\AR24Bundle\Model;

class EndPoints
{
    // Get user informations.
    public const GET_USER = 'user/';

    // Send an email to a recipient.
    public const POST_LRE = 'mail/';

    // Get informations about an email.
    public const GET_LRE_INFO = 'mail/';

    // Post an attachment.
    public const POST_ATTACHMENT = 'attachment/';

    // Authenticate with OTP.
    public const AUTHENTICATE_OTP = 'user/auth_otp/';

    // Get registered mail list.
    public const GET_REGISTERED_LRE_LIST = 'user/mail';
}
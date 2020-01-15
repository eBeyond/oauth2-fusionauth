<?php

namespace eBeyond\OAuth2\Client\Exception;

/**
 * Exception thrown if the FusionAuth Provider is configured with a hosted domain that the user doesn't belong to
 */
class HostedDomainException extends \Exception
{

    public static function notMatchingDomain($configuredDomain)
    {
        return new static("User is not part of domain '$configuredDomain'");
    }
}

<?php

namespace eBeyond\OAuth2\Client\Provider;

use League\OAuth2\Client\Exception\HostedDomainException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Provider\GenericProvider;
use Psr\Http\Message\ResponseInterface;

class FusionAuth extends GenericProvider 
{

}

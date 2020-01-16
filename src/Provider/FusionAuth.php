<?php

namespace eBeyond\OAuth2\Client\Provider;

use League\OAuth2\Client\Exception\HostedDomainException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Tool\GuardedPropertyTrait;
use League\OAuth2\Client\Provider\GenericProvider;
use Psr\Http\Message\ResponseInterface;
use eBeyond\OAuth2\Client\Provider\FusionAuthIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider

class FusionAuth extends AbstractProvider 
{
    use BearerAuthorizationTrait;
    use GuardedPropertyTrait;
    
    public $urlAuthorize;
    public $urlAccessToken;
    public $urlResourceOwnerDetails;
    public $redirectUri;
    
    
    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://github.com';
    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://api.github.com';
    
    
    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);
        $this->fillProperties($options);
    }
    
    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->$urlAuthorize;
    }
    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->urlAccessToken;
    }
    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->urlResourceOwnerDetails;
    }
    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }
    /**
     * Check a provider response for errors.
     *
     * @link   https://developer.github.com/v3/#client-errors
     * @link   https://developer.github.com/v3/oauth/#common-errors-for-the-access-token-request
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw FusionAuthIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw FusionAuthIdentityProviderException::oauthException($response, $data);
        }
    }
    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new FusionAuthUser($response);
    }
}

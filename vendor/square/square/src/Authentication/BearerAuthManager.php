<?php

declare(strict_types=1);

namespace Square\Authentication;

use Core\Authentication\CoreAuth;
use Core\Request\Parameters\HeaderParam;
use Core\Utils\CoreHelper;
use Square\BearerAuthCredentials;

/**
 * Utility class for authorization and token management.
 */
class BearerAuthManager extends CoreAuth implements BearerAuthCredentials
{
    private $accessToken;

    /**
     * Returns an instance of this class.
     *
     * @param string $accessToken The OAuth 2.0 Access Token to use for API requests.
     */
    public function __construct(string $accessToken)
    {
        parent::__construct(
            HeaderParam::init('Authorization', CoreHelper::getBearerAuthString($accessToken))->requiredNonEmpty()
        );
        $this->accessToken = $accessToken;
    }

    /**
     * String value for accessToken.
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Checks if provided credentials match with existing ones.
     *
     * @param string $accessToken The OAuth 2.0 Access Token to use for API requests.
     */
    public function equals(string $accessToken): bool
    {
        return $accessToken == $this->accessToken;
    }
}

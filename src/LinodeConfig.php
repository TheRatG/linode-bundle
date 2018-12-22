<?php

namespace TheRat\LinodeBundle;

class LinodeConfig
{
    const BASE_URI = 'https://api.linode.com/v4/';

    protected $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getBaseUri()
    {
        return self::BASE_URI;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
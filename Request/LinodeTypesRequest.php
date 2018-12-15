<?php

namespace TheRat\LinodeBundle\Request;

use GuzzleHttp\Psr7\ServerRequest;

class LinodeTypesRequest extends ServerRequest
{
    public function __construct()
    {
        parent::__construct('GET', 'linode/types');
    }
}

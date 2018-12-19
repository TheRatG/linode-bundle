<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;

class RegionsService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function loadList()
    {
        $request = new ServerRequest('GET', 'regions');
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function view(string $regionId)
    {
        $request = new ServerRequest('GET', 'regions/' . $regionId);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }
}
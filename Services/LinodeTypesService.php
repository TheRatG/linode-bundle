<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;

class LinodeTypesService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function loadList()
    {
        $request = new ServerRequest('GET', 'linode/types');
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function view($typeId)
    {
        $request = new ServerRequest('GET', 'linode/types/' . $typeId);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }
}
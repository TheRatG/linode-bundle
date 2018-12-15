<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;

class LinodeInstancesService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function loadList(int $page = 1, int $pageSize = 100)
    {
        $request = new ServerRequest('GET', 'linode/instances');
        $request->withQueryParams([
            'page' => $page,
            'page_size' => $pageSize
        ]);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function view(int $linodeId)
    {
        $request = new ServerRequest('GET', 'linode/instances/' . $linodeId);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

}
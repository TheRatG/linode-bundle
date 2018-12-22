<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;
use TheRat\LinodeBundle\Model\Networking\AssigmentCollection;

class NetworkingService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function ipv4Assign($region, AssigmentCollection $assigmentCollection)
    {
        $params = [
            'region' => $region,
            'assignments' => $assigmentCollection->toArray(),
        ];
        $request = new ServerRequest('POST', 'networking/ipv4/assign', [], json_encode($params));
        $response = $this->getLinodeClient()->send($request);

        return $response;
    }
}
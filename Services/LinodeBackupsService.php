<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;
use TheRat\LinodeBundle\Response\ItemResponse;

class LinodeBackupsService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function loadList(int $linodeId)
    {
        $request = new ServerRequest('GET', 'linode/instances/' . $linodeId . '/backups');
        $result = $this->getLinodeClient()->send($request);

        $data = $result->getData();

        $backups = [];
        foreach ($data['automatic'] as $item) {
            $backups[] = $item;
        }
        $backups[] = $data['snapshot']['current'];
        usort($backups, function ($a, $b) {
            $a = $a['created'];
            $b = $b['created'];

            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });

        return new ItemResponse($backups);
    }

    public function view(int $linodeId, int $backupId)
    {
        $request = new ServerRequest(
            'GET',
            'linode/instances/' . $linodeId . '/backups/' . $backupId
        );
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }
}
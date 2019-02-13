<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;
use TheRat\LinodeBundle\Model\Instances\BackupCollection;
use TheRat\LinodeBundle\Model\Instances\BackupModel;
use TheRat\LinodeBundle\Response\ItemResponse;

class LinodeBackupsService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    /**
     * @param int $linodeId
     * @return BackupCollection|BackupModel[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loadList(int $linodeId): BackupCollection
    {
        $request = new ServerRequest('GET', 'linode/instances/' . $linodeId . '/backups');
        $response = $this->getLinodeClient()->send($request);

        $rows = [];
        foreach ($response['automatic'] as $item) {
            $rows[] = $item;
        }
        $rows[] = $response['snapshot']['current'];
        usort($rows, function ($a, $b) {
            $a = $a['created'];
            $b = $b['created'];

            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });
        $rows = array_filter($rows);

        $result = new BackupCollection($rows);

        return $result;
    }

    public function view(int $linodeId, int $backupId)
    {
        $request = new ServerRequest(
            'GET',
            'linode/instances/' . $linodeId . '/backups/' . $backupId
        );
        $response = $this->getLinodeClient()->send($request);

        $result = new BackupModel();
        $result->populate($response);

        return $result;
    }
}

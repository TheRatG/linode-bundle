<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;
use TheRat\LinodeBundle\Response\ItemResponse;
use TheRat\LinodeBundle\Response\ListResponse;

class LinodeInstancesService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function view(int $linodeId)
    {
        $request = new ServerRequest('GET', 'linode/instances/' . $linodeId);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function viewByLabel($label): ?ItemResponse
    {
        $result = null;
        $page = 1;
        do {
            $response = $this->loadList($page++);
            $rows = $response->getData();
            foreach ($rows as $row) {
                if ($label === $row['label']) {
                    $result = $row;
                    break;
                }
            }
        } while (!empty($rows));

        return $result;
    }

    public function loadList(int $page = 1, int $pageSize = 100): ?ListResponse
    {
        $request = new ServerRequest('GET', 'linode/instances');
        $request->withQueryParams([
            'page' => $page,
            'page_size' => $pageSize
        ]);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function create($type, $region, $backupId)
    {
        $request = new ServerRequest('POST', 'linode/instances', [], json_encode([
            'type' => $type,
            'region' => $region,
            'backup_id' => $backupId
        ]));
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function reboot($linodeId)
    {
        $request = new ServerRequest('POST', 'linode/instances/' . $linodeId . '/reboot');
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }

    public function delete($linodeId)
    {
        $request = new ServerRequest('DELETE', 'linode/instances/' . $linodeId);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }
}
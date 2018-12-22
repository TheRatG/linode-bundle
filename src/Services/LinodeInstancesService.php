<?php

namespace TheRat\LinodeBundle\Services;

use GuzzleHttp\Psr7\ServerRequest;
use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;
use TheRat\LinodeBundle\Model\Instances\LinodeCollection;
use TheRat\LinodeBundle\Model\Instances\LinodeModel;
use TheRat\LinodeBundle\Response\ItemResponse;
use TheRat\LinodeBundle\Response\ListResponse;

class LinodeInstancesService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;

    public function view(int $linodeId)
    {
        $request = new ServerRequest('GET', 'linode/instances/' . $linodeId);
        $response = $this->getLinodeClient()->send($request);

        $result = new LinodeModel();
        $result->populate($response);

        return $result;
    }

    public function viewByLabel($label): ?LinodeModel
    {
        $result = null;

        $page = 1;
        do {
            $response = $this->loadList($page++);
            foreach ($response['data'] as $row) {
                if ($label === $row['label']) {
                    $result = new LinodeModel();
                    $result->populate($row);
                    break;
                }
            }
        } while (!empty($rows));

        return $result;
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return LinodeModel[]|LinodeCollection|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loadList(int $page = 1, int $pageSize = 100): ?LinodeCollection
    {
        $request = new ServerRequest('GET', 'linode/instances');
        $request->withQueryParams([
            'page' => $page,
            'page_size' => $pageSize,
        ]);

        $response = $this->getLinodeClient()->send($request);
        $result = new LinodeCollection($response['data'], $response['page'], $response['pages'], $response['results']);

        return $result;
    }

    public function create($type, $region, $backupId, $label = null)
    {
        $params = [
            'type' => $type,
            'region' => $region,
            'backup_id' => $backupId,
        ];
        if ($label) {
            $params['label'] = $label;
        }
        $request = new ServerRequest('POST', 'linode/instances', [], json_encode($params));
        $response = $this->getLinodeClient()->send($request);
        $result = new LinodeModel();
        $result->populate($response);

        return $result;
    }

    public function boot($linodeId): bool
    {
        $request = new ServerRequest('POST', 'linode/instances/' . $linodeId . '/boot');
        $this->getLinodeClient()->send($request);

        return true;
    }

    public function reboot($linodeId): bool
    {
        $request = new ServerRequest('POST', 'linode/instances/' . $linodeId . '/reboot');
        $this->getLinodeClient()->send($request);

        return true;
    }

    public function delete($linodeId)
    {
        $request = new ServerRequest('DELETE', 'linode/instances/' . $linodeId);
        $result = $this->getLinodeClient()->send($request);

        return $result;
    }
}
<?php

namespace TheRat\LinodeBundle;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use TheRat\LinodeBundle\Model\ErrorCollection;
use TheRat\LinodeBundle\Response\ErrorsResponse;
use TheRat\LinodeBundle\Response\ItemResponse;
use TheRat\LinodeBundle\Response\ListResponse;

class LinodeClient
{
    /**
     * @var ClientInterface
     */
    protected $guzzleClient;
    /**
     * @var LinodeConfig
     */
    private $config;

    public function __construct(LinodeConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @param null $response
     * @return mixed|ErrorCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(RequestInterface $request, array $options = [], &$response = null)
    {
        $response = $this->getGuzzleClient()->send($request, $options);

        $result = json_decode($response->getBody(), true);
        if (array_key_exists('errors', $result)) {
            $result = new ErrorCollection($result['errors']);
        }

        return $result;
    }

    /**
     * @return ClientInterface
     */
    public function getGuzzleClient(): ClientInterface
    {
        if (is_null($this->guzzleClient)) {
            return new Client([
                'base_uri' => $this->config->getBaseUri(),
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->config->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);
        }

        return $this->guzzleClient;
    }

    /**
     * @param ClientInterface $guzzleClient
     */
    public function setGuzzleClient(ClientInterface $guzzleClient): void
    {
        $this->guzzleClient = $guzzleClient;
    }
}
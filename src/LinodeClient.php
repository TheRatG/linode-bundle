<?php

namespace TheRat\LinodeBundle;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
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
     * @return ErrorsResponse|ItemResponse|ListResponse|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(RequestInterface $request, array $options = [], &$response = null)
    {
        $response = $this->getGuzzleClient()->send($request, $options);

        $responseData = json_decode($response->getBody(), true);
        $result = null;
        if (array_key_exists('errors', $responseData)) {
            $errors = $responseData['errors'];
            $result = new ErrorsResponse();
            foreach ($errors as $error) {
                $result->addError($error);
            }
        } elseif (array_key_exists('page', $responseData) && array_key_exists('pages', $responseData)) {
            $result = new ListResponse(
                $responseData['data'],
                $responseData['page'],
                $responseData['pages'],
                $responseData['results']
            );
        } else {
            $result = new ItemResponse($responseData);
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
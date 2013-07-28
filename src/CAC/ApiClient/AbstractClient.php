<?php

namespace CAC\ApiClient;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\ClientInterface;

/**
 * Base API Client
 *
 */
abstract class AbstractClient
{
    /**
     * HTTP Client
     *
     * @var Guzzle\Http\ClientInterface
     */
    private $httpClient;

    public function __construct(ClientInterface $httpClient, $baseUrl = null)
    {
        $this->httpClient = $httpClient;
        if (null !== $baseUrl) {
            $this->httpClient->setBaseUrl($baseUrl);
        }
    }

    /**
     * Perform a HTTP Request
     *
     * @param RequestInterface $request The Request
     *
     * @throws \HuiswerkAf\Exception\InvalidDataException Bad Request Exception
     * @return mixed
     */
    private function request(RequestInterface $request)
    {
        $response = $request->send();

        if ($response->isSuccessful()) {
            // @todo Handle on content type
            return $response->json();
        }

        // @todo Handle when errors occur

        return $response;
    }

    /**
     * Perform a GET request
     *
     * @param string $url        The URL to call
     * @param array  $parameters List of parameters to attach. These will be added as query parameters
     *
     * @return array The parsed response
     */
    public function get($url, array $parameters = array())
    {
        if ($parameters) {
            $url = sprintf("%s?%s", $url, http_build_query($parameters));
        }

        return $this->request($this->httpClient->get($url));
    }

    /**
     * Perform a POST request
     *
     * @param string $url        The URL to call
     * @param array  $parameters List of parameters to attach. These will be added as body content. Parameters will be json encoded
     *
     * @return array The parsed response
     */
    public function post($url, $parameters = array())
    {
        $request = $this->httpClient->post($url);
        if ($parameters) {
            $request->setBody(json_encode($parameters), 'application/json');
        }

        return $this->request($request);
    }

    /**
     * Perform a PUT request
     *
     * @param string $url        The URL to call
     * @param array  $parameters List of parameters to attach. These will be added as body content. Parameters will be json encoded
     *
     * @return array The parsed response
     */
    public function put($url, $parameters = array())
    {
        $request = $this->httpClient->put($url);
        if ($parameters) {
            $request->setBody(json_encode($parameters), 'application/json');
        }

        return $this->request($request);
    }

    /**
     * Perform a DELETE request
     *
     * @param string $url        The URL to call
     *
     * @return array The parsed response
     */
    public function delete($url)
    {
        return $this->request($this->httpClient->delete($url));
    }
}

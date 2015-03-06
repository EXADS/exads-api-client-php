<?php

namespace Exads\Api;

use Exads\Client;

/**
 * Abstract class for Api classes.
 */
abstract class AbstractApi
{
    /**
     * The client.
     *
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Perform the client get() method.
     *
     * @param string $path
     *
     * @return array
     */
    protected function get($path, $decode = true)
    {
        return $this->client->get($path, $decode);
    }

    /**
     * Perform the client post() method.
     *
     * @param string $path
     * @param string $data
     *
     * @return string|false
     */
    protected function post($path, $data = null)
    {
        return $this->client->post($path, $data);
    }

    /**
     * Perform the client put() method.
     *
     * @param string $path
     * @param string $data
     *
     * @return string|false
     */
    protected function put($path, $data = null)
    {
        return $this->client->put($path, $data);
    }

    /**
     * Perform the client delete() method.
     *
     * @param string $path
     *
     * @return array
     */
    protected function delete($path)
    {
        return $this->client->delete($path);
    }

    /**
     * Checks if the variable passed is not null.
     *
     * @param mixed $var Variable to be checked
     *
     * @return bool
     */
    protected function isNotNull($var)
    {
        return !is_null($var);
    }

    /**
     * Retrieves all the elements of a given endpoint (even if the
     * total number of elements is greater than 100).
     *
     * @param string $endpoint API end point
     * @param array  $params   optional parameters to be passed to the api (offset, limit, ...)
     *
     * @return array elements found
     */
    protected function retrieveAll($endpoint, array $params = array())
    {
        if (empty($params)) {
            return $this->get($endpoint);
        }
        $defaults = array(
            'limit'  => 25,
            'offset' => 0,
        );
        $params = array_filter(
            array_merge($defaults, $params),
            array($this, 'isNotNull')
        );

        $ret = array();

        return $ret;
    }

    /**
     * @param string $endPoint
     *
     * @return string
     */
    protected function getPath($endPoint = null)
    {
        return sprintf('%s', $this->apiGroup);
    }
}

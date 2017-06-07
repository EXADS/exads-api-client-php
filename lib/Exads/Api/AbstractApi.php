<?php

namespace Exads\Api;

use Exads\Client;

/**
 * Abstract class for Api classes.
 */
abstract class AbstractApi
{
    /**
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
     * {@inheritdoc}
     */
    protected function get($path, array $params = array(), $decode = true)
    {
        return $this->client->get($path, $params, $decode);
    }

    /**
     * {@inheritdoc}
     */
    protected function post($path, $data = null, array $headers = [])
    {
        return $this->client->post($path, $data, $headers);
    }

    /**
     * {@inheritdoc}
     */
    protected function put($path, $data = null)
    {
        return $this->client->put($path, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function delete($path, $data = null)
    {
        return $this->client->delete($path, $data);
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
            'limit' => 25,
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

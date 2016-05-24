<?php

namespace Exads;

interface ClientInterface
{
    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return Api\AbstractApi
     */
    public function api($name);

    /**
     * Decodes json response.
     *
     * Returns $json if no error occured during decoding but decoded value is
     * null.
     *
     * @param string $json
     *
     * @return array|string
     */
    public function decode($json);

    /**
     * HTTP POSTs $data to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return mixed
     */
    public function post($path, $data = null);

    /**
     * HTTP PUTs $data to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return array
     */
    public function put($path, $data = null);

    /**
     * HTTP DELETEs $data to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return array
     */
    public function delete($path, $data = null);
}

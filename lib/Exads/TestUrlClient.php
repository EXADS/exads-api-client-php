<?php

namespace Exads;

class TestUrlClient extends Client
{
    /**
     * @param string $path
     * @param bool   $decode
     *
     * @return array
     */
    public function get($path, array $params = array(), $decode = true)
    {
        if (count($params) > 0) {
            $path = sprintf('%s?%s', $path, http_build_query($params));
        }

        return $this->runRequest($path, 'GET');
    }

    /**
     * @param string $path
     * @param string $method
     * @param string $data
     *
     * @return string
     *
     * @throws \Exception If anything goes wrong on curl request
     */
    protected function runRequest($path, $method = 'GET', $data = '')
    {
        return array(
            'method' => $method,
            'path' => $path,
        );
    }
}

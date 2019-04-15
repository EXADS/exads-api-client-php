<?php

namespace Exads;

class TestUrlClient extends Client
{
    /**
     * @param string $path
     * @param array  $params
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
     * @param string|array $data
     * @param array $headers
     *
     * @throws \Exception If anything goes wrong on curl request
     *
     * @return array
     */
    protected function runRequest($path, $method = 'GET', $data = '', $headers = [])
    {
        $result = array(
            'method' => $method,
            'path' => $path,
        );

        // Try decode data
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (JSON_ERROR_NONE === json_last_error()) {
                $data = $decoded;
            }
        }
        // Add data element only if it present
        if ($data) {
            $result['data'] = $data;
        }

        return $result;
    }
}

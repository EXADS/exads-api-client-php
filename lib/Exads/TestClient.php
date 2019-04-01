<?php

namespace Exads;

class TestClient extends Client
{
    /**
     * @param string $path
     * @param string $method
     * @param string|array $data
     * @param array $headers
     *
     * @throws \Exception always!
     *
     * @return string
     */
    protected function runRequest($path, $method = 'GET', $data = '', $headers = [])
    {
        throw new \Exception('not available');
    }
}

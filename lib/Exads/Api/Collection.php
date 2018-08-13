<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/collections
 */
class Collection extends AbstractApi
{
    protected $apiGroup = 'collections';

    /**
     * @param array $params
     *
     * @return array
     */
    public function all(array $params = array())
    {
        return $this->get($this->getPath('all'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function browsers(array $params = array())
    {
        return $this->get($this->getPath('browsers'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function carriers(array $params = array())
    {
        return $this->get($this->getPath('carriers'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function categories(array $params = array())
    {
        return $this->get($this->getPath('categories'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function devices(array $params = array())
    {
        return $this->get($this->getPath('devices'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function languages(array $params = array())
    {
        return $this->get($this->getPath('languages'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function os(array $params = array())
    {
        return $this->get($this->getPath('os'), $params);
    }

    /**
     * @param string $endPoint
     *
     * @return string
     */
    protected function getPath($endPoint = null)
    {
        $pathMapping = array(
            'all' => '%s',
            'browsers' => '%s/browsers',
            'carriers' => '%s/carriers',
            'categories' => '%s/categories',
            'devices' => '%s/devices',
            'languages' => '%s/languages',
            'os' => '%s/operating-systems',
        );
        if (!isset($pathMapping[$endPoint])) {
            throw new \InvalidArgumentException('Non existing path');
        }
        $path = $pathMapping[$endPoint];

        return sprintf($path, $this->apiGroup);
    }
}

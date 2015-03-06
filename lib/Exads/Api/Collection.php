<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/collections
 */
class Collection extends AbstractApi
{
    protected $apiGroup = 'collections';

    /**
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath('all'));
    }

    /**
     * @return array
     */
    public function browsers()
    {
        return $this->get($this->getPath('browsers'));
    }

    /**
     * @return array
     */
    public function carriers()
    {
        return $this->get($this->getPath('carriers'));
    }

    /**
     * @return array
     */
    public function categories()
    {
        return $this->get($this->getPath('categories'));
    }

    /**
     * @return array
     */
    public function devices()
    {
        return $this->get($this->getPath('devices'));
    }

    /**
     * @return array
     */
    public function languages()
    {
        return $this->get($this->getPath('languages'));
    }

    /**
     * @return array
     */
    public function os()
    {
        return $this->get($this->getPath('os'));
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

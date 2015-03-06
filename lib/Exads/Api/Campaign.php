<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/campaigns
 */
class Campaign extends AbstractApi
{
    protected $apiGroup = 'campaigns';

    /**
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath('all'));
    }

    /**
     * @param  string $id
     * @return array
     */
    public function show($id)
    {
        return $this->get($this->getPath('show', $id));
    }

    /**
     * @param  string $id
     * @return boolean
     */
    public function copy($id)
    {
        return $this->put($this->getPath('copy', $id));
    }

    /**
     * @param  string $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->put($this->getPath('delete', $id));
    }

    /**
     * @param  string $id
     * @return boolean
     */
    public function pause($id)
    {
        return $this->put($this->getPath('pause', $id));
    }

    /**
     * @param  string $id
     * @return boolean
     */
    public function play($id)
    {
        return $this->put($this->getPath('play', $id));
    }

    /**
     * @param  string $id
     * @return boolean
     */
    public function restore($id)
    {
        return $this->put($this->getPath('restore', $id));
    }

    /**
     * @param  string $endPoint
     * @return string
     */
    protected function getPath($endPoint = null, $id = null)
    {
        $pathMapping = array(
            'all' => '%s',
            'show' => '%s/%s',
            'copy' => '%s/%s/copy',
            'delete' => '%s/%s/delete',
            'pause' => '%s/%s/pause',
            'play' => '%s/%s/play',
            'restore' => '%s/%s/restore',
        );
        if (!isset($pathMapping[$endPoint])) {
            throw new \InvalidArgumentException('Non existing path');
        }
        $path = $pathMapping[$endPoint];

        if (null === $id) {
            return sprintf($path, $this->apiGroup);
        }
        return sprintf($path, $this->apiGroup, urlencode($id));
    }
}

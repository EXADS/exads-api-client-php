<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/statistics
 */
abstract class AbstractStatistics extends AbstractApi
{
    protected $apiGroup = 'statistics';
    protected $subGroup = null;

    public function browser()
    {
        return $this->get($this->getPath('browser'));
    }

    public function carrier()
    {
        return $this->get($this->getPath('carrier'));
    }

    public function category()
    {
        return $this->get($this->getPath('category'));
    }

    public function country()
    {
        return $this->get($this->getPath('country'));
    }

    public function date()
    {
        return $this->get($this->getPath('date'));
    }

    public function device()
    {
        return $this->get($this->getPath('device'));
    }

    public function hour()
    {
        return $this->get($this->getPath('hour'));
    }

    public function os()
    {
        return $this->get($this->getPath('os'));
    }

    public function site()
    {
        return $this->get($this->getPath('site'));
    }

    protected function getPath($endPoint = null)
    {
        return sprintf('%s/%s/%s', $this->apiGroup, $this->subGroup, $endPoint);
    }
}

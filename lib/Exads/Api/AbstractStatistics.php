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
        return $this->post($this->getPath('browser'));
    }

    public function carrier()
    {
        return $this->post($this->getPath('carrier'));
    }

    public function category()
    {
        return $this->post($this->getPath('category'));
    }

    public function country()
    {
        return $this->post($this->getPath('country'));
    }

    public function date()
    {
        return $this->post($this->getPath('date'));
    }

    public function device()
    {
        return $this->post($this->getPath('device'));
    }

    public function hour()
    {
        return $this->post($this->getPath('hour'));
    }

    public function os()
    {
        return $this->post($this->getPath('os'));
    }

    public function site()
    {
        return $this->post($this->getPath('site'));
    }

    protected function getPath($endPoint = null)
    {
        return sprintf('%s/%s/%s', $this->apiGroup, $this->subGroup, $endPoint);
    }
}

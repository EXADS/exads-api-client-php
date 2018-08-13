<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/statistics
 */
abstract class AbstractStatistics extends AbstractApi
{
    protected $apiGroup = 'statistics';
    protected $subGroup = null;

    /**
     * @param array $params
     *
     * @return array
     */
    public function browser(array $params = array())
    {
        return $this->get($this->getPath('browser'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function carrier(array $params = array())
    {
        return $this->get($this->getPath('carrier'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function category(array $params = array())
    {
        return $this->get($this->getPath('category'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function country(array $params = array())
    {
        return $this->get($this->getPath('country'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function date(array $params = array())
    {
        return $this->get($this->getPath('date'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function device(array $params = array())
    {
        return $this->get($this->getPath('device'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function hour(array $params = array())
    {
        return $this->get($this->getPath('hour'), $params);
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
     * @param array $params
     *
     * @return array
     */
    public function language(array $params = array())
    {
        return $this->get($this->getPath('language'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function site(array $params = array())
    {
        return $this->get($this->getPath('site'), $params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function zone(array $params = array())
    {
        return $this->get($this->getPath('zone'), $params);
    }

    protected function getPath($endPoint = null)
    {
        return sprintf('%s/%s/%s', $this->apiGroup, $this->subGroup, $endPoint);
    }
}

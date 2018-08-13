<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/statistics
 */
class StatisticsPublisher extends AbstractStatistics
{
    protected $subGroup = 'publisher';

    /**
     * @param array $params
     *
     * @return array
     */
    public function sub(array $params = array())
    {
        return $this->get($this->getPath('sub'), $params);
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
}

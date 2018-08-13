<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/statistics
 */
class StatisticsAdvertiser extends AbstractStatistics
{
    protected $subGroup = 'advertiser';

    /**
     * @param array $params
     *
     * @return array
     */
    public function variation(array $params = array())
    {
        return $this->get($this->getPath('variation'), $params);
    }
}

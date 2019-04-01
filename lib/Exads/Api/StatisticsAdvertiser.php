<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/statistics
 */
class StatisticsAdvertiser extends AbstractStatistics
{
    protected $subGroup = 'advertiser';

    /**
     * Get advertiser statistics by variation.
     *
     * @param array $params
     *
     * @return array
     */
    public function variation(array $params = array())
    {
        return $this->get($this->getPath('variation'), $params);
    }

    /**
     * Get advertiser statistics by campaign.
     *
     * @param array $params
     *
     * @return array
     */
    public function campaign(array $params = array())
    {
        return $this->get($this->getPath('campaign'), $params);
    }
}

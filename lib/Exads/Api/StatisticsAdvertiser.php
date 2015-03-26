<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/statistics
 */
class StatisticsAdvertiser extends AbstractStatistics
{
    protected $subGroup = 'advertiser';

    public function language()
    {
        return $this->get($this->getPath('language'));
    }

    public function variation()
    {
        return $this->get($this->getPath('variation'));
    }
}

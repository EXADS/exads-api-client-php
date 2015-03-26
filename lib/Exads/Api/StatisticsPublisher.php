<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/statistics
 */
class StatisticsPublisher extends AbstractStatistics
{
    protected $subGroup = 'publisher';

    public function sub()
    {
        return $this->get($this->getPath('sub'));
    }

    public function zone()
    {
        return $this->get($this->getPath('zone'));
    }
}

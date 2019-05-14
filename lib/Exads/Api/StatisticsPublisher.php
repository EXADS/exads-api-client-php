<?php

namespace Exads\Api;

/**
 * @link   https://api.exoclick.com/v2/docs/index.html#!/47statistics
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
}

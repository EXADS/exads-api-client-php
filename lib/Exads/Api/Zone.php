<?php

namespace Exads\Api;

/**
 * @link   https://api.exoclick.com/v2/docs/index.html#!/47zones
 */
class Zone extends AbstractApi
{
    protected $apiGroup = 'zones';

    /**
     * @param array $params
     *
     * @return array
     */
    public function all(array $params = array())
    {
        return $this->get($this->getPath(), $params);
    }
}

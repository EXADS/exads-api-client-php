<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/zones
 */
class Zone extends AbstractApi
{
    protected $apiGroup = 'zones';

    /**
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath());
    }
}

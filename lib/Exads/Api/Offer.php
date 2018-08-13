<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/offers
 */
class Offer extends AbstractApi
{
    protected $apiGroup = 'offers';

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

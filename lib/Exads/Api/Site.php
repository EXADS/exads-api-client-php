<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/sites
 */
class Site extends AbstractApi
{
    protected $apiGroup = 'sites';

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

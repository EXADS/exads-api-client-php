<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/sites
 */
class Site extends AbstractApi
{
    protected $apiGroup = 'sites';

    /**
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath());
    }
}

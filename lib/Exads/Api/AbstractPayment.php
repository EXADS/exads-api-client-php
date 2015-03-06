<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/payments
 */
class AbstractPayment extends AbstractApi
{
    protected $apiGroup = 'payments';

    /**
     * @return array
     */
    public function all()
    {
        return $this->get($this->getPath());
    }

    protected function getPath($endPoint = null)
    {
        return sprintf('%s/%s', $this->apiGroup, $this->subGroup);
    }
}

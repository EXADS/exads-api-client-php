<?php

namespace Exads\Api;

/**
 * @link   https://api.exoclick.com/v2/docs/index.html#!/47payments
 */
class AbstractPayment extends AbstractApi
{
    protected $apiGroup = 'payments';

    /**
     * @param array $params
     *
     * @return array
     */
    public function all(array $params = array())
    {
        return $this->get($this->getPath(), $params);
    }

    /**
     * @param string $endPoint
     *
     * @return string
     */
    protected function getPath($endPoint = null)
    {
        return sprintf('%s/%s', $this->apiGroup, $this->subGroup);
    }
}

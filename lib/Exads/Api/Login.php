<?php

namespace Exads\Api;

/**
 * @link  https://api.exads.com/v1/docs/index.html#!/login
 */
class Login extends AbstractApi
{
    protected $apiGroup = 'login';

    /**
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function getToken($username, $password)
    {
        $data = array(
            'username' => $username,
            'password' => $password,
        );

        return $this->post($this->getPath(), $data);
    }

    /**
     * @param string $api_token
     *
     * @return string
     */
    public function getTokenByApiToken($api_token)
    {
        $data = array(
            'api_token' => $api_token
        );

        return $this->post($this->getPath(), $data);
    }
}

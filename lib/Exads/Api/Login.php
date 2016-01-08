<?php

namespace Exads\Api;

/**
 * @link  https://api.exads.com/v1/docs/index.html#!/login
 */
class Login extends AbstractApi
{
    protected $apiGroup = 'login';

    /**
     * @param string $usernameOrApiToken
     * @param string $password
     *
     * @return string
     */
    public function getToken($usernameOrApiToken, $password = null)
    {

        if(is_null($password) || empty($password))
        {

            $data = array(
                'api_token' => $usernameOrApiToken
            );

        } else {

            $data = array(
                'username' => $usernameOrApiToken,
                'password' => $password,
            );

        }

        return $this->post($this->getPath(), $data);
    }
}

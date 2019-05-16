<?php

namespace Exads\Api;

/**
 * @link  https://api.exoclick.com/v2/docs/index.html#!/47login
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
        $data = array(
            'api_token' => $usernameOrApiToken,
        );

        if (null !== $password) {
            $data = array(
                'username' => $usernameOrApiToken,
                'password' => $password,
            );
        }

        return $this->post($this->getPath(), $data);
    }
}

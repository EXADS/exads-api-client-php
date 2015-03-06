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
        var_dump($this->post($this->getPath(), $data));

        return $this->post($this->getPath(), $data);
    }
}

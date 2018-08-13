<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/user
 */
class User extends AbstractApi
{
    protected $apiGroup = 'user';

    /**
     * @param array $params
     *
     * @return array
     */
    public function show(array $params = array())
    {
        return $this->get($this->getPath('get'), $params);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function update(array $data = array())
    {
        return $this->put($this->getPath('get'), $data);
    }

    /**
     * @return array
     */
    public function changepassword($password, $newpassword)
    {
        $data = array(
            'password' => $password,
            'new_password' => $newpassword,
        );

        return $this->post($this->getPath('changepassword'), $data);
    }

    /**
     * @return array
     */
    public function resetpassword($email, $username)
    {
        $data = array(
            'email' => $email,
            'username' => $username,
            'token' => $this->client->getApiToken(),
        );

        return $this->post($this->getPath('resetpassword'), $data);
    }

    /**
     * @param string $endPoint
     *
     * @return string
     */
    protected function getPath($endPoint = null)
    {
        $pathMapping = array(
            'get' => '%s',
            'changepassword' => '%s/changepassword',
            'resetpassword' => '%s/resetpassword',
        );
        if (!isset($pathMapping[$endPoint])) {
            throw new \InvalidArgumentException('Non existing path');
        }
        $path = $pathMapping[$endPoint];

        return sprintf($path, $this->apiGroup);
    }
}

<?php

namespace Exads;

use Exads\Api\SimpleXMLElement;

/**
 * Simple PHP Exads client.
 *
 * @link http://github.com/exads/php-exads-api
 */
class Client
{
    /**
     * @var array
     */
    private static $defaultPorts = array(
        'http'  => 80,
        'https' => 443,
    );

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $apiToken = null;

    /**
     * @var string or null
     */
    private $pass;

    /**
     * @var boolean
     */
    private $checkSslCertificate = false;

    /**
     * @var boolean
     */
    private $checkSslHost = false;

    /**
     * @var array APIs
     */
    private $apis = array();

    /**
     * @var int|null Exads response code, null if request is not still completed
     */
    private $responseCode = null;

    /**
     * Error strings if json is invalid.
     */
    private static $jsonErrors = array(
        JSON_ERROR_NONE => 'No error has occurred',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Syntax error',
    );

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->getPort();
    }

    /**
     * @param string $name
     *
     * @return Api\AbstractApi
     *
     * @throws \InvalidArgumentException
     */
    public function api($name)
    {
        $classes = array(
            'campaigns' => 'Campaign',
            'login' => 'Login',
            'collections' => 'Collection',
            'payments_advertiser' => 'PaymentAdvertiser',
            'payments_publisher' => 'PaymentPublisher',
            'sites' => 'Site',
            'statistics_advertiser' => 'StatisticsAdvertiser',
            'statistics_publisher' => 'StatisticsPublisher',
            'user' => 'User',
            'zones' => 'Zone',
        );
        if (!isset($classes[$name])) {
            throw new \InvalidArgumentException();
        }
        if (isset($this->apis[$name])) {
            return $this->apis[$name];
        }
        $c = 'Exads\Api\\'.$classes[$name];
        $this->apis[$name] = new $c($this);

        return $this->apis[$name];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Client
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * HTTP GETs a json $path and tries to decode it.
     *
     * @param string  $path
     * @param boolean $decode
     *
     * @return array
     */
    public function get($path, $decode = true)
    {
        if (false === $json = $this->runRequest($path, 'GET')) {
            return false;
        }

        if (!$decode) {
            return $json;
        }

        return $this->decode($json);
    }

    /**
     * Decodes json response.
     *
     * Returns $json if no error occured during decoding but decoded value is
     * null.
     *
     * @param string $json
     *
     * @return array|string
     */
    public function decode($json)
    {
        $decoded = json_decode($json, true);
        if (null !== $decoded) {
            return $decoded;
        }
        if (JSON_ERROR_NONE === json_last_error()) {
            return $json;
        }

        return self::$jsonErrors[json_last_error()];
    }

    /**
     * HTTP POSTs $params to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return mixed
     */
    public function post($path, $data = null)
    {
        if (null === $data) {
            $data = array();
        }
        if (is_array($data)) {
            $data = json_encode($data);
        }

        return $this->runRequest($path, 'POST', $data);
    }

    /**
     * HTTP PUTs $params to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return array
     */
    public function put($path, $data = null)
    {
        if (null === $data) {
            $data = array();
        }
        if (is_array($data)) {
            $data = json_encode($data);
        }

        return $this->runRequest($path, 'PUT', $data);
    }

    /**
     * HTTP PUTs $params to $path.
     *
     * @param string $path
     *
     * @return array
     */
    public function delete($path)
    {
        return $this->runRequest($path, 'DELETE');
    }

    /**
     * Turns on/off ssl certificate check.
     *
     * @param boolean $check
     *
     * @return Client
     */
    public function setCheckSslCertificate($check = false)
    {
        $this->checkSslCertificate = $check;

        return $this;
    }

    /**
     * Turns on/off ssl host certificate check.
     *
     * @param boolean $check
     *
     * @return Client
     */
    public function setCheckSslHost($check = false)
    {
        $this->checkSslHost = $check;

        return $this;
    }

    /**
     * Set the port of the connection.
     *
     * @param int $port
     *
     * @return Client
     */
    public function setPort($port = null)
    {
        if (null !== $port) {
            $this->port = (int) $port;
        }

        return $this;
    }

    /**
     * Returns Exads response code.
     *
     * @return int
     */
    public function getResponseCode()
    {
        return (int) $this->responseCode;
    }

    /**
     * Returns the port of the current connection,
     * if not set, it will try to guess the port
     * from the url of the client.
     *
     * @return int the port number
     */
    public function getPort()
    {
        if (null !== $this->port) {
            return $this->port;
        }

        $tmp = parse_url($this->getUrl());
        if (isset($tmp['port'])) {
            $this->setPort($tmp['port']);
        } elseif (isset($tmp['scheme'])) {
            $this->setPort(self::$defaultPorts[$tmp['scheme']]);
        }

        return $this->port;
    }

    /**
     * Set the apiToken object globally from json encoded token object.
     *
     * @param string $apiToken json token object
     *
     * @return Client
     */
    public function setApiToken($apiToken)
    {
        $apiTokenObject = json_decode($apiToken);
        var_dump($apiTokenObject);
        $this->apiToken = sprintf('%s %s', $apiTokenObject->type, $apiTokenObject->token);

        return $this;
    }

    /**
     * @return string
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @param string $path
     * @param string $method
     * @param string $data
     *
     * @return boolean|SimpleXMLElement|string
     *
     * @throws \Exception If anything goes wrong on curl request
     */
    protected function runRequest($path, $method = 'GET', $data = '')
    {
        $this->responseCode = null;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url.$path);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_PORT, $this->getPort());
        if (80 !== $this->getPort()) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->checkSslCertificate);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->checkSslHost);
        }

        $requestHeader = array(
            'Expect:',
            'Content-Type: application/json',
        );
        if (null !== $this->apiToken) {
            $requestHeader[] = sprintf('Authorization: %s', $this->apiToken);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeader);

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                if (isset($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                if (isset($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default: // GET
                break;
        }
        $rawResponse = trim(curl_exec($curl));

        if (curl_errno($curl)) {
            $e = new \Exception(curl_error($curl), curl_errno($curl));
            curl_close($curl);
            throw $e;
        }

        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $response = $this->parseResponse($rawResponse, $headerSize);

        if ($this->isErrorCode($responseCode)) {
            $e = new \Exception($response['body']);
            curl_close($curl);
            throw $e;
        }
        curl_close($curl);

        if ($response['body']) {
            return $response['body'];
        }

        return true;
    }

    /**
     * @param int $code
     *
     * @return boolean
     */
    private function isErrorCode($code)
    {
        return 400 <= (int) $code && (int) $code <= 599;
    }

    private function parseResponse($rawResponse, $headerSize)
    {
        $header = substr($rawResponse, 0, $headerSize);
        $body = substr($rawResponse, $headerSize);

        $headers = array();
        $rawHeader = substr($rawResponse, 0, strpos($rawResponse, "\r\n\r\n"));
        foreach (explode("\r\n", $rawHeader) as $i => $line) {
            if (0 === $i) {
                $headers['http_code'] = $line;
            } else {
                list($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        return array(
            'headers' => $headers,
            'body' => $body,
        );
    }
}

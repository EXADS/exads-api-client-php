<?php

namespace Exads;

use Exads\Api\SimpleXMLElement;

/**
 * Simple PHP Exads client.
 *
 * @link http://github.com/exads/php-exads-api
 *
 * @property-read Api\Campaign $campaigns
 * @property-read Api\Login $login
 * @property-read Api\Collection $collections
 * @property-read Api\PaymentAdvertiser $payments_advertiser
 * @property-read Api\PaymentPublisher $payments_publisher
 * @property-read Api\Site $sites
 * @property-read Api\StatisticsAdvertiser $statistics_advertiser
 * @property-read Api\StatisticsPublisher $statistics_publisher
 * @property-read Api\User $user
 * @property-read Api\Zone $zones
 */
class Client implements ClientInterface
{
    /**
     * @var array
     */
    private static $defaultPorts = array(
        'http' => 80,
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
     * @var bool
     */
    private $checkSslCertificate = false;

    /**
     * @var bool
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

    private $classes = array(
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
     * @throws \InvalidArgumentException
     *
     * @return Api\AbstractApi
     */
    public function api($name)
    {
        if (!isset($this->classes[$name])) {
            throw new \InvalidArgumentException('Available api : '.implode(', ', array_keys($this->classes)));
        }
        if (isset($this->apis[$name])) {
            return $this->apis[$name];
        }
        $c = 'Exads\Api\\'.$this->classes[$name];
        $this->apis[$name] = new $c($this);

        return $this->apis[$name];
    }

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return Api\AbstractApi
     */
    public function __get($name)
    {
        return $this->api($name);
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
     * @param string $path
     * @param array  $params
     * @param bool   $decode
     *
     * @return array|string
     */
    public function get($path, array $params = array(), $decode = true)
    {
        if (count($params) > 0) {
            $path = sprintf('%s?%s', $path, http_build_query($params));
        }
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
        if ('' === $json) {
            return '';
        }
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
     * @param array  $headers
     *
     * @return bool|string
     */
    public function post($path, $data = null, $headers = [])
    {
        if ( empty($headers['Content-Type']) || $headers['Content-Type'] == 'application/json' ) {
            $data = $this->encodeData($data);
        }

        return $this->runRequest($path, 'POST', $data, $headers);
    }

    /**
     * HTTP PUTs $params to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return bool|string
     */
    public function put($path, $data = null)
    {
        $data = $this->encodeData($data);

        return $this->runRequest($path, 'PUT', $data);
    }

    /**
     * HTTP PUTs $params to $path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return bool|string
     */
    public function delete($path, $data = null)
    {
        if (null === $data) {
            return $this->runRequest($path, 'DELETE');
        }
        $data = $this->encodeData($data);

        return $this->runRequest($path, 'DELETE', $data);
    }

    /**
     * Turns on/off ssl certificate check.
     *
     * @param bool $check
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
     * @param bool $check
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
     * Returns Exads response code.
     *
     * @return int
     */
    public function getResponseCode()
    {
        return (int) $this->responseCode;
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
     * @param string|array $data
     * @param array $headers
     *
     * @throws \Exception If anything goes wrong on curl request
     *
     * @return bool|string
     */
    protected function runRequest($path, $method = 'GET', $data = '', $headers = [])
    {
        $this->responseCode = null;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url.$path);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_PORT, $this->getPort());
        if (80 !== $this->getPort()) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->checkSslCertificate);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->checkSslHost);
        }

        $requestHeader = array(
            'Expect:',
            'Content-Type: application/json'
        );

        if ( ! empty($headers) ) {
            foreach ($headers as $key => $value) {
                $existingKey = $this->array_match(sprintf("%s", $key), $requestHeader);
                $valueStr = sprintf("%s: %s", $key, $value);
                if ( $existingKey !== false ) {
                    $requestHeader[$existingKey] = $valueStr;
                } else {
                    $requestHeader[] = $valueStr;
                }
            }
        }

        if (null !== $this->apiToken) {
            $requestHeader[] = sprintf('Authorization: %s', $this->apiToken);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeader);
        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
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
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (isset($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
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
     * @return bool
     */
    private function isErrorCode($code)
    {
        return 400 <= (int) $code && (int) $code <= 599;
    }

    /**
     * @param mixed $data
     *
     * @return array|json
     */
    private function encodeData($data = null)
    {
        if (is_array($data)) {
            return json_encode($data);
        }

        return array();
    }

    /**
     * @param string $rawResponse
     * @param string $headerSize
     *
     * @return array
     */
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

    /**
     * @param $needle
     * @param $haystack
     * @return bool|int
     */
    public function array_match($needle, $haystack)
    {
        $i = 0;
        $n = count($haystack);
        $key = false;
        do {
            if ( strpos($haystack[$i], $needle) !== false ) {
                $key = $i;
            }
            $i ++;
        } while ( $key === false && $i < $n );

        return $key;
    }
}

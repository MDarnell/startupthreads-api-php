<?php

/**
 * Client library for the StartupThreads API.
 *
 * Uses curl to request JSON responses from the StartupThreads API.
 *
 * Contributors:
 * Matthew Darnell <mdarnell@calculatedchaos.com>
 *
 * @author Matthew Darnell <mdarnell@calculatedchaos.com>
 * @version 0.1
 */
class StartupThreads
{
    /**
     * Library Version
     */
    const VERSION = '0.1';

    /**
     * HTTP Methods
     */
    const METHOD_GET    = 'get';
    const METHOD_POST   = 'post';
    const METHOD_PUT    = 'put';
    const METHOD_PATCH  = 'patch';
    const METHOD_DELETE = 'delete';

    private $api_token;
    private $api_endpoint = 'https://api.startupthreads.com';
    private $api_headers  = [];
    private $verify_ssl   = true;

    /**
     * Create a new instance
     *
     * @param string $api_token The user WhenIWork API token
     * @param array $options Allows you to set the `headers` and the `endpoint`
     */
    function __construct($api_token = null, $options = [])
    {
        $this->api_token = $api_token;

        if (!empty($options['endpoint'])) {
            $this->setEndpoint($options['endpoint']);
        }
        if (!empty($options['headers'])) {
            $this->setHeaders($options['headers'], true);
        }
    }

    /**
     * Set the API key for all requests
     *
     * @param string $api_token The StartupThreads API key
     * @return StartupThreads
     */
    public function setToken($api_token)
    {
        $this->api_token = $api_token;

        return $this;
    }

    /**
     * Get the API key to save for future requests
     *
     * @return string The user StartupThreads API key
     */
    public function getToken()
    {
        return $this->api_token;
    }

    /**
     * Set the endpoint for all requests
     *
     * @param string $endpoint The StartupThreads API endpoint to use
     * @return StartupThreads
     */
    public function setEndpoint($endpoint)
    {
        $this->api_endpoint = $endpoint;

        return $this;
    }

    /**
     * Get the endpoint to use for future requests
     *
     * @return string The StartupThreads API endpoint
     */
    public function getEndpoint()
    {
        return $this->api_endpoint;
    }

    /**
     * Set the headers for all requests
     *
     * @param array $headers Global headers for all future requests
     * @param bool $reset
     * @return $this
     */
    public function setHeaders(array $headers, $reset = false)
    {
        if ($reset === true) {
            $this->api_headers = $headers;
        } else {
            $this->api_headers += $headers;
        }

        return $this;
    }

    /**
     * Get the host to use for future requests
     *
     * @return array Global headers array
     */
    public function getHeaders()
    {
        return $this->api_headers;
    }

    /**
     * Get an object or list.
     *
     * @param  string $method The API method to call, e.g. '/items.json'
     * @param  array $params An array of arguments to pass to the method.
     * @param  array $headers Array of custom headers to be passed
     * @return array           Object of json decoded API response.
     */
    public function get($method, $params = [], $headers = [])
    {
        return $this->makeRequest($method, self::METHOD_GET, $params, $headers);
    }

    /**
     * Post to an endpoint.
     *
     * @param  string $method The API method to call, e.g. '/inventory_shipments'
     * @param  array $params An array of data used to create the object.
     * @param  array $headers Array of custom headers to be passed
     * @return array           Object of json decoded API response.
     */
    public function post($method, $params = [], $headers = [])
    {
        return $this->makeRequest($method, self::METHOD_POST, $params, $headers);
    }

    /**
     * Create an object. Helper method for post.
     *
     * @param  string $method The API method to call, e.g. '/inventory_shipments'
     * @param  array $params An array of data used to create the object.
     * @param  array $headers Array of custom headers to be passed
     * @return array           Object of json decoded API response.
     */
    public function create($method, $params = [], $headers = [])
    {
        return $this->post($method, $params, $headers);
    }

    /**
     * Update an object. Must include the ID.
     *
     * @param  string $method The API method to call, e.g. '/users/1'
     * @param  array $params An array of data to update the object. Only changed fields needed.
     * @param  array $headers Array of custom headers to be passed
     * @return array           Object of json decoded API response.
     */
    public function update($method, $params = [], $headers = [])
    {
        return $this->makeRequest($method, self::METHOD_PUT, $params, $headers);
    }

    /**
     * Delete an object. Must include the ID.
     *
     * @param  string $method The API method to call, e.g. '/users/1'
     * @param  array $params An array of arguments to pass to the method.
     * @param  array $headers Array of custom headers to be passed
     * @return array           Object of json decoded API response.
     */
    public function delete($method, $params = [], $headers = [])
    {
        return $this->makeRequest($method, self::METHOD_DELETE, $params, $headers);
    }


    /**
     * Performs the underlying HTTP request. Exciting stuff happening here. Not really.
     *
     * @param  string $method The API method to be called
     * @param  string $request The type of request
     * @param  array $params Assoc array of parameters to be passed
     * @param  array $headers Assoc array of custom headers to be passed
     * @return array           Assoc array of decoded result
     */
    private function makeRequest($method, $request, $params = [], $headers = [])
    {
        $url = $this->getEndpoint() . '/' . $method;

        if ($params && ($request == self::METHOD_GET || $request == self::METHOD_DELETE)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'StartupThreads-PHP/' . static::VERSION);

        $headers += $this->getHeaders();

        $headers['Accept'] = 'application/vnd.startupthreads-v1+json';
        $headers['Content-Type'] = 'application/json';
        if ($this->api_token) {
            $headers['Authorization'] = 'Token token="' . $this->api_token . '"';
        }

        $headers_data = [];
        foreach ($headers as $k => $v) {
            $headers_data[] = $k . ': ' . $v;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_data);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($request));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);

        if (in_array($request, [self::METHOD_POST, self::METHOD_PUT, self::METHOD_PATCH])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return $result ? json_decode($result) : false;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/22/17
 * Time: 3:45 PM
 * Desc: 公共的Http的Trait类
 */

namespace Liguanh\JdySms\Traits;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait HttpRequest
{

    /**
     * @desc Create a Get Request
     * @param $endpoint
     * @param array $query
     * @param array $headers
     * @return mixed|string
     */
    public function get($endpoint, $query = [], $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query' => $query,
        ]);
    }

    /**
     * @desc Create a Post request
     * @param $endpoint
     * @param array $params
     * @param array $headers
     * @return mixed|string
     */
    public function post($endpoint, $params = [], $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'form_params' => $params,
        ]);
    }

    /**
     * @desc Create a Http request
     *
     * @param $method string
     * @param $endpoint string
     * @param $options array
     * @return mixed|string
     */
    public function request($method, $endpoint, $options)
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));
    }


    /**
     * @desc Convert response contents to json
     *
     * @param ResponseInterface $response
     * @return mixed|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();

        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        }

        return $contents;
    }

    /**
     * @desc Return the Client Instance
     * @param array $options
     * @return Client
     */
    public function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    /**
     * @desc Return base Guzzle options.
     * @return array
     */
    public function getBaseOptions()
    {
        $options = [
            'base_uri' => method_exists($this, 'getBaseUri') ? $this->getBaseUri() : '',
            'timeout' => property_exists($this, 'timeout') ? $this->timeout : 5.0,
        ];

        return $options;
    }

}
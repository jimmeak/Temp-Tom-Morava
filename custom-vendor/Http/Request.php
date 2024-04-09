<?php

namespace Mordor\Storage\Http;

use Mordor\Storage\List\ArrayList;

class Request
{
    private string $requestUri;
    private string $requestMethod;

    public ArrayList $query;
    public ArrayList $request;
    public ArrayList $server;
    public ArrayList $cookies;

    public function __construct()
    {
        $this->query = ArrayList::new($_GET);
        $this->request = ArrayList::new($_POST);
        $this->server = ArrayList::new($_SERVER);
        $this->cookies = ArrayList::new($_COOKIE);

        $this->requestUri = $this->server->get('REQUEST_URI', '/');
        $this->requestMethod = $this->server->get('REQUEST_METHOD', 'GET');
    }


    public function getBaseUri(): string
    {
        return sprintf('%s://%s/',
            $this->server->get('REQUEST_SCHEME', 'http'),
            $this->server->get('HTTP_HOST', 'localhost')
        );
    }

    public function getBasePath(): string
    {
        return parse_url($this->requestUri, PHP_URL_PATH) ?? '/';
    }

    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }
}
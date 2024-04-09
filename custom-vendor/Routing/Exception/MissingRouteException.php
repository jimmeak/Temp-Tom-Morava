<?php

namespace Mordor\Storage\Routing\Exception;

use Exception;

class MissingRouteException extends Exception
{
    public function __construct(string $url, string $method)
    {
        $method = strtoupper($method);
        parent::__construct(sprintf('Route with method %s at url %s has not been found.', $method, $url));
    }
}
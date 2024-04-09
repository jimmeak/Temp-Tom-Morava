<?php

namespace Mordor\Storage\Http;

class Response
{
    public function __construct(
        private string $content = '',
        private ResponseCode $status = ResponseCode::OK
    ) {
    }

    public function __toString(): string
    {
        return 'HTTP/1.1 ' . $this->status->value . PHP_EOL . 'Content-Type: text/html; charset=utf-8' . PHP_EOL . PHP_EOL . $this->content;
    }
}
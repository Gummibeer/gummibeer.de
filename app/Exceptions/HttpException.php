<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;

class HttpException extends SymfonyHttpException
{
    public static function make(SymfonyHttpException $e)
    {
        return new static(
            $e->getStatusCode(),
            $e->getMessage(),
            $e,
            $e->getHeaders(),
            $e->getCode()
        );
    }

    public function getStatusText()
    {
        return isset(Response::$statusTexts[$this->getStatusCode()]) ? Response::$statusTexts[$this->getStatusCode()] : 'unknown status';
    }
}
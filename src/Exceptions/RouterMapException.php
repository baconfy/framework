<?php

namespace Baconfy\Exceptions;

use RuntimeException;

final class RouterMapException extends RuntimeException implements ExceptionInterface
{
    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $code = '';
}
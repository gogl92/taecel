<?php namespace Taecel\Taecel\Throwables;

use Exception;
use Throwable;

class ServerIsOffline extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = __('Server is offline');
    }
}
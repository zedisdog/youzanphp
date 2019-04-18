<?php
/**
 * Created by zed.
 */
declare(strict_types=1);
namespace Dezsidog\Youzanphp\Exceptions;


use Throwable;

class BadRequestException extends \RuntimeException
{
    public function __construct(bool $success, int $code, string $message, Throwable $previous = null)
    {
        $message = sprintf("bad request: [code: %d, success: %s, message: %s]", $code, $success ? "true" : "false", $message);
        parent::__construct($message, $code, $previous);
    }
}
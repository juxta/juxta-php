<?php

namespace Juxta\Db\Exception;

use Juxta\Exception\ExceptionAttachTrait;
use RuntimeException;

final class ConnectErrorException extends RuntimeException implements DbException
{
    use ExceptionAttachTrait;

    protected $message = 'Connect error';
}
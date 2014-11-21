<?php

namespace Juxta\Exception;

use \RuntimeException;

final class SessionNotFoundException extends RuntimeException implements Exception
{
    use ExceptionAttachTrait;

    protected $message = 'Session not found';
}
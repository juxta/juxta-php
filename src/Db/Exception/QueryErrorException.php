<?php

namespace Juxta\Db\Exception;

use Juxta\Exception\ExceptionAttachTrait;
use RuntimeException;

final class QueryErrorException extends RuntimeException implements DbException
{
    use ExceptionAttachTrait;
}
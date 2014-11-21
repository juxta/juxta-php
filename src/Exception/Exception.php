<?php

namespace Juxta\Exception;

interface Exception
{
    /**
     * @param mixed
     */
    public function attach($object);

    /**
     * @return mixed
     */
    public function getAttachment();
}